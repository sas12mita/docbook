**For Patients:
**•	User Sign-up/Sign-in: Users can create an account using a unique phone number and password, and choose if they are a doctor or patient.
•	Basic User Details: Patients can enter their personal information for easy follow-up.
•	View Available Doctors: Patients can see a list of available doctors and their free time slots.
•	Book Appointments: Patients can book appointments with doctors based on their availability.
•	Doctor Information: Patients can view basic information about doctors, including name, contact info, specialty, and free time slots.
**For Doctors:**
•	User Sign-up/Sign-in: Same as for patients.
•	Basic User Details: Doctors can enter their personal and professional information.
•	View Appointments: Doctors can view appointments booked by patients.
•	Manage Schedule: Doctors can mark holidays or leave on their calendar to prevent booking conflicts.
•	View Patient Details: Doctors can view basic patient details for easy diagnosis.
The application likely uses a calendar system to manage appointments and avoid scheduling conflicts.

User:
Id,
Name,
Email,
Password,
role,
Address,


Doctor:
Id,
user_id,
Specialization_id,

Patient:
Id,
User_id,

Specialization
Id,
Name,

Appointment:
Id,
Doc_id,
Patient_id,
Appointment date and time

schedule:
doctor_id
date
start_time
end_time
day




