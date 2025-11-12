# 🩺 Diabetes Prediction System — Laravel + Flask (ML Integrated)

## 🚀 Overview

A full-stack health prediction system built with **Laravel** (backend) and **Flask (Python)** for ML model integration.  
The system supports **Admin**, **Doctor**, and **Patient** roles with role-based dashboards, appointments, and report management.

---

## 🔐 Common (Authenticated Routes)

| Method | Route        | Controller | Description                                                      |
| ------ | ------------ | ---------- | ---------------------------------------------------------------- |
| GET    | `/dashboard` | —          | Redirect user to respective dashboard (admin / doctor / patient) |
| POST   | `/logout`    | —          | Logout current user                                              |

---

## 🧑‍💼 ADMIN ROUTES

| Method           | Route              | Controller@Method       | Description                           |
| ---------------- | ------------------ | ----------------------- | ------------------------------------- |
| **🏠 Dashboard** |
| GET              | `/admin/dashboard` | `AdminController@index` | Admin dashboard with stats & ML chart |

| **👨‍⚕️ Doctor Management** |
| GET | `/doctors` | `DoctorController@index` | List all doctors |
| GET | `/doctors/create` | `DoctorController@create` | Add new doctor |
| POST | `/doctors` | `DoctorController@store` | Save doctor info |
| GET | `/doctors/{doctor}/edit` | `DoctorController@edit` | Edit doctor details |
| PUT | `/doctors/{doctor}` | `DoctorController@update` | Update doctor info |
| DELETE | `/doctors/{doctor}` | `DoctorController@destroy` | Delete a doctor |

| **🧍‍♂️ Patient Management** |
| GET | `/patients` | `PatientController@index` | View all patients |
| GET | `/patients/create` | `PatientController@create` | Add new patient |
| POST | `/patients` | `PatientController@store` | Store patient data |
| GET | `/patients/{patient}` | `PatientController@show` | View patient profile |
| DELETE | `/patients/{patient}` | `PatientController@destroy` | Delete a patient |
| GET | `/patients/{patient}/download` | `PatientController@downloadReport` | Download patient PDF report |
| GET | `/patients/{patient}/report` | `AdminController@downloadReport` | Generate patient report (PDF) |

| **📅 Appointment Management** |
| GET | `/appointments` | `AppointmentController@index` | List all appointments |
| GET | `/appointments/create` | `AppointmentController@create` | Create appointment form |
| POST | `/appointments` | `AppointmentController@store` | Save appointment |
| PATCH | `/appointments/{appointment}/status` | `AppointmentController@updateStatus` | Update appointment status |
| DELETE | `/appointments/{appointment}` | `AppointmentController@destroy` | Delete appointment |

| **📊 Report Management** |
| GET | `/reports` | `ReportController@index` | View all reports |
| DELETE | `/reports/{patient}` | `ReportController@destroy` | Delete a report |

| **👤 User Role Management** |
| GET | `/users` | `UserController@index` | View all system users |
| PUT | `/users/{user}/role` | `UserController@updateRole` | Change user role (admin/doctor/patient) |

---

## 🧑‍⚕️ DOCTOR ROUTES

| Method           | Route               | Controller@Method            | Description                               |
| ---------------- | ------------------- | ---------------------------- | ----------------------------------------- |
| **🏠 Dashboard** |
| GET              | `/doctor/dashboard` | `DoctorController@dashboard` | Doctor dashboard (appointments, patients) |

| **📅 Appointments** |
| POST | `/doctor/appointments/{appointment}/approve` | `DoctorController@approve` | Approve patient appointment |
| POST | `/doctor/appointments/{appointment}/cancel` | `DoctorController@cancel` | Cancel appointment |

| **🧾 Reports & Notes** |
| GET | `/doctor/patients/{patient}/report` | `DoctorController@viewReport` | View patient medical report |
| POST | `/doctor/appointments/{appointment}/notes` | `DoctorController@storeNote` | Add notes for patient visit |

---

## ⚙️ Middleware Summary

| Middleware   | Used By       | Purpose                                   |
| ------------ | ------------- | ----------------------------------------- |
| `auth`       | All routes    | Ensures user is logged in                 |
| `verified`   | `/dashboard`  | Only verified users can access dashboards |
| `can:admin`  | Admin routes  | Restrict routes to admin role only        |
| `can:doctor` | Doctor routes | Restrict routes to doctor role only       |

---

## 🧠 Tech Stack

-   **Backend:** Laravel 12 (PHP 8.3)
-   **ML Integration:** Flask (Python 3.13)
-   **Database:** PostgreSQL
-   **Frontend:** Blade (Bootstrap 5)
-   **ML Models:** Logistic Regression, Random Forest, Decision Tree, SVM, KNN

---

## 📦 Project Features

✅ Admin dashboard with real-time ML accuracy chart  
✅ Doctor dashboard for viewing and managing appointments  
✅ Secure user authentication and role-based authorization  
✅ Appointment management (CRUD)  
✅ Auto-generated patient reports (PDF via DomPDF)  
✅ Flask-based ML prediction API integrated via HTTP

---

## 🔗 ML API Endpoint (Flask)

| Method | Endpoint                        | Description                                                    |
| ------ | ------------------------------- | -------------------------------------------------------------- |
| POST   | `http://127.0.0.1:5000/predict` | Returns model predictions and accuracies based on patient data |

**Example JSON request:**

```json
{
    "Pregnancies": 0,
    "Glucose": 150,
    "BloodPressure": 80,
    "SkinThickness": 25,
    "Insulin": 100,
    "BMI": 30.0,
    "DiabetesPedigreeFunction": 0.5,
    "Age": 45
}
```
