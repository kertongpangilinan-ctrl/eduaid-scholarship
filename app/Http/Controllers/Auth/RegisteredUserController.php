<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PersonalInfo;
use App\Models\AddressInfo;
use App\Models\FamilyInfo;
use App\Models\Sibling;
use App\Models\EducationalInfo;
use App\Models\Application;
use App\Models\Document;
use App\Models\Notification;
use App\Models\OTPVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    public function create()
    {
        // Restore form data from session if available
        if (session()->has('registrationFormData')) {
            $formData = session('registrationFormData');
            // Flash the form data to the old() helper
            foreach ($formData as $key => $value) {
                session()->flash("_old_input.{$key}", $value);
            }
            // Clear the session data after flashing
            session()->forget('registrationFormData');
        }
        
        // Restore current step from session if available
        $currentStep = session('registrationCurrentStep', 1);
        session()->forget('registrationCurrentStep');
        
        return view('auth.register', ['currentStep' => $currentStep]);
    }
    
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                // Account validation
                'username' => 'required|string|min:6|max:20|alpha_num|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/|confirmed',
                
                // Personal info validation
                'last_name' => 'required|string|max:50',
                'first_name' => 'required|string|max:50',
                'middle_name' => 'nullable|string|max:50',
                'extension_name' => 'nullable|string|max:10',
                'gender' => 'required|in:Male,Female',
                'date_of_birth' => 'required|date|before_or_equal:' . Carbon::now()->subYears(16)->format('Y-m-d'),
                'civil_status' => 'required|in:Single,Married,Widowed,Separated',
                'contact_number' => 'required|string|max:15|regex:/^09[0-9]{9}$/',
                
                // Address validation
                'house_unit_number' => 'required|string|max:50',
                'street_name' => 'required|string|max:100',
                'barangay' => 'required|string|max:100',
                
                // Family validation
                'father_name' => 'required|string|max:100',
                'mother_name' => 'required|string|max:100',
                'number_of_siblings' => 'nullable|integer|min:0|max:10',
                'siblings' => 'nullable|array',
                'siblings.*.name' => 'nullable|string|max:100',
                'siblings.*.gender' => 'nullable|in:Male,Female',
                'siblings.*.birth_date' => 'nullable|date',
                'siblings.*.occupation' => 'nullable|string|max:100',
                
                // Educational info validation
                'education_level' => 'required|in:Incoming First Year College,College',
                'school_name' => 'required|string|max:200',
                'semester_type' => 'required|in:2 Semesters,3 Semesters',
                'current_semester' => 'required_if:semester_type,2 Semesters,3 Semesters|in:1st Semester,2nd Semester,3rd Semester',
                'year_level' => 'nullable|required_if:education_level,College|in:1st Year,2nd Year,3rd Year,4th Year',
                
                // Incoming First Year College fields (nullable when not applicable)
                'lrn' => 'nullable|required_if:education_level,Incoming First Year College|digits:11',
                'shs_strand' => 'nullable|required_if:education_level,Incoming First Year College|in:STEM,ABM,HUMSS,GAS,TVL,SPORTS,ARTS & DESIGN,Other',
                'shs_strand_other' => 'nullable|required_if:shs_strand,Other|string|max:100',
                
                // College fields (nullable when not applicable)
                'school_id_type' => 'nullable|required_if:education_level,College|in:Current School ID,Certificate of Registration (COR),Certificate of Enrollment (COE),Registration Form,Official Receipt,Other',
                'school_id_type_other' => 'nullable|required_if:school_id_type,Other|string|max:100',
                'school_id_number' => 'nullable|required_if:education_level,College|string|max:50',
                
                // Document validation
                'proof_of_residency' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'picture_2x2' => 'required|file|mimes:jpg,jpeg,png|max:1024',
                'school_id_front' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'school_id_back' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'letter_of_intent' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'recent_grades' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'signature' => 'required|file|mimes:jpg,jpeg,png|max:1024',
                'cor_coe' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                
                'terms_agreed' => 'required|accepted'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Store form data in session for preservation
            session()->put('registrationFormData', $request->except(['password', 'password_confirmation', 'proof_of_residency', 'picture_2x2', 'school_id_front', 'school_id_back', 'letter_of_intent', 'recent_grades', 'signature', 'cor_coe']));
            session()->put('registrationCurrentStep', $request->input('current_step', 1));
            
            // Check if request is AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            
            throw $e;
        }
        
        // Wrap entire registration in database transaction
        return \DB::transaction(function () use ($request, $validated) {
            // Create user
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'student',
                'account_status' => 'pending_admin_approval',
                'email_verified_at' => now(),
            ]);
        
            // Create personal info
            PersonalInfo::create([
                'user_id' => $user->id,
                'last_name' => $validated['last_name'],
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'],
                'extension_name' => $validated['extension_name'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'civil_status' => $validated['civil_status'],
                'contact_number' => $validated['contact_number']
            ]);
            
            // Create address info
            AddressInfo::create([
                'user_id' => $user->id,
                'house_unit_number' => $validated['house_unit_number'],
                'street_name' => $validated['street_name'],
                'barangay' => $validated['barangay'],
                'municipality_city' => 'General Tinio',
                'province' => 'Nueva Ecija'
            ]);
            
            // Create family info
            $familyInfo = FamilyInfo::create([
                'user_id' => $user->id,
                'father_name' => $validated['father_name'],
                'father_occupation' => $request->father_occupation,
                'father_salary' => $request->father_salary,
                'father_birth_date' => $request->father_birth_date,
                'mother_name' => $validated['mother_name'],
                'mother_occupation' => $request->mother_occupation,
                'mother_salary' => $request->mother_salary,
                'mother_birth_date' => $request->mother_birth_date,
                'number_of_siblings' => $validated['number_of_siblings'] ?? count($request->siblings ?? [])
            ]);
            
            // Create siblings
            if ($request->has('siblings')) {
                foreach ($request->siblings as $sibling) {
                    if (!empty($sibling['name'])) {
                        Sibling::create([
                            'family_info_id' => $familyInfo->family_info_id,
                            'name' => $sibling['name'],
                            'birth_date' => $sibling['birth_date'] ?? null,
                            'occupation' => $sibling['occupation'] ?? null,
                            'gender' => $sibling['gender'] ?? null
                        ]);
                    }
                }
            }
            
            // Create educational info
            EducationalInfo::create([
                'user_id' => $user->id,
                'education_level' => $validated['education_level'],
                'school_name' => $validated['school_name'],
                'semester_type' => $validated['semester_type'],
                'current_semester' => $validated['current_semester'] ?? null,
                'year_level' => $validated['year_level'] ?? null,
                'lrn' => $validated['lrn'] ?? null,
                'shs_strand' => ($validated['shs_strand'] ?? null) === 'Other' 
                    ? ($validated['shs_strand_other'] ?? null) 
                    : ($validated['shs_strand'] ?? null),
                'school_id_type' => ($validated['school_id_type'] ?? null) === 'Other' 
                    ? ($validated['school_id_type_other'] ?? null) 
                    : ($validated['school_id_type'] ?? null),
                'school_id_number' => $validated['school_id_number'] ?? null
            ]);
            
            // Generate unique reference number
            do {
                $referenceNumber = 'SCHOLAR-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            } while (Application::where('reference_number', $referenceNumber)->exists());
            
            // Create application without batch assignment
            try {
                $application = Application::create([
                    'user_id' => $user->id,
                    'reference_number' => $referenceNumber,
                    'batch_id' => null,
                    'status' => 'pending',
                    'submission_date' => now()
                ]);
                \Log::info('Application created successfully', ['application_id' => $application->application_id, 'user_id' => $user->id]);
            } catch (\Exception $e) {
                \Log::error('Failed to create application: ' . $e->getMessage());
                throw $e;
            }
            
            // Update user with reference number
            $user->update(['reference_number' => $referenceNumber]);
            
            // Create notification for all admin users
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'sent_by' => $user->id,
                    'title' => 'New Scholarship Application',
                    'message' => "New application from {$user->name}. Reference: {$referenceNumber}",
                    'type' => 'registration',
                    'is_read' => false,
                    'sent_at' => now()
                ]);
            }
            
            // Upload documents
            $documentTypes = [
                'proof_of_residency', 'picture_2x2', 'school_id_front', 'school_id_back',
                'letter_of_intent', 'recent_grades', 'signature', 'cor_coe'
            ];
            
            foreach ($documentTypes as $docType) {
                if ($request->hasFile($docType)) {
                    try {
                        $file = $request->file($docType);
                        $path = $file->store("documents/{$referenceNumber}/{$docType}", 'public');
                        
                        Document::create([
                            'user_id' => $user->id,
                            'document_type' => $docType,
                            'file_path' => $path,
                            'file_name' => $file->getClientOriginalName(),
                            'file_type' => $file->getClientMimeType(),
                            'file_size' => $file->getSize() / 1024,
                            'verification_status' => 'pending'
                        ]);
                        \Log::info("Document uploaded: {$docType}", ['user_id' => $user->id]);
                    } catch (\Exception $e) {
                        \Log::error("Failed to upload document {$docType}: " . $e->getMessage());
                    }
                } else {
                    \Log::warning("Missing document: {$docType}", ['user_id' => $user->id]);
                }
            }
            
            // Send reference number email
            try {
                Mail::raw(
                    "Dear {$user->name},\n\n" .
                    "Thank you for registering with EduAid Scholarship Program.\n\n" .
                    "Your application has been submitted successfully.\n\n" .
                    "Your Reference Number: {$referenceNumber}\n\n" .
                    "Please save this reference number. You can use it to track your application status on our website.\n\n" .
                    "Application Status: Pending\n\n" .
                    "Your application is now under review by our admin team. You will receive an email notification once your application has been approved.\n\n" .
                    "Thank you for your interest in our scholarship program!\n\n" .
                    "Best regards,\n" .
                    "EduAid Scholarship Team",
                    function ($message) use ($user) {
                        $message->to($user->email)
                                ->subject('EduAid - Application Submitted Successfully');
                    }
                );
            } catch (\Exception $e) {
                \Log::error('Failed to send reference number email: ' . $e->getMessage());
            }
            
            // Clear form data
            session()->forget('registrationFormData');
            
            // Check if request is AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'reference_number' => $referenceNumber,
                    'batch_id' => null
                ]);
            }
            
            return redirect()->route('application-status', ['reference' => $referenceNumber])
                ->with('success', 'Your application has been submitted successfully!');
        });
    }
}
