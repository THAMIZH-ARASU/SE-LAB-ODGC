# PTU Advanced Portal - Online OD And Career Guidance Management System

[![PHP](https://img.shields.io/badge/PHP-8.0+-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-green.svg)](https://mysql.com)
[![PHPMailer](https://img.shields.io/badge/PHPMailer-6.9+-orange.svg)](https://github.com/PHPMailer/PHPMailer)
[![TCPDF](https://img.shields.io/badge/TCPDF-6.9+-red.svg)](https://tcpdf.org)

A comprehensive web-based Leave Management System for Puducherry Technological University (PTU) that streamlines the process of submitting, reviewing, and approving On Duty (OD) applications and Career Guidance forms.

## 🎯 Features

### Core Functionality
- **Multi-Role Authentication System** with OTP verification
- **Online OD Application Submission** with document uploads
- **Career Guidance Form Management**
- **Hierarchical Approval Workflow** (Student → Teacher → HOD → Dean → VC)
- **Email Notifications** for application status updates
- **PDF Report Generation** for analytics and records
- **Attendance Marking System** for approved applications
- **Bulk Operations** for efficient processing

### User Roles & Permissions
- **Students**: Submit OD applications, career guidance forms, view history
- **Teachers**: Mark attendance, review applications
- **HODs**: Approve/reject applications, forward to teachers
- **Deans**: Oversee department-wise applications, generate reports
- **Vice Chancellor**: Access analytics, download reports, override decisions

### Technical Features
- **Responsive Design** for mobile and desktop compatibility
- **File Upload Management** with size and format validation
- **Real-time Status Tracking** of applications
- **Advanced Filtering** and search capabilities
- **Data Export** functionality
- **Session Management** and security

## 🏗️ System Architecture

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Frontend      │    │   Backend       │    │   Database      │
│   (HTML/CSS/JS) │◄──►│   (PHP)         │◄──►│   (MySQL)       │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                              │
                              ▼
                       ┌─────────────────┐
                       │   External      │
                       │   Services      │
                       │   (SMTP/PDF)    │
                       └─────────────────┘
```

## 📋 Prerequisites

Before running this application, ensure you have:

- **Web Server**: Apache/Nginx with PHP support
- **PHP**: Version 8.0 or higher
- **MySQL**: Version 5.7 or higher
- **Composer**: For dependency management
- **SMTP Server**: For email notifications (Gmail recommended)

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd Online_Od
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Database Setup
1. Create a MySQL database named `online_od`
2. Import the database schema:
```bash
mysql -u root -p online_od < Database/online_od.sql
```

### 4. Configuration
1. **Database Configuration**: Update `db.php` with your database credentials
```php
$host = 'localhost';
$dbname = 'online_od';
$username = 'your_username';
$password = 'your_password';
```

2. **Email Configuration**: Update email settings in relevant files:
```php
$EMAIL_ADDRESS = "your-email@gmail.com";
$EMAIL_PASSWORD = "your-app-specific-password";
```

3. **File Permissions**: Ensure the `uploads/` directory is writable
```bash
chmod 755 uploads/
```

### 5. Web Server Configuration
- Point your web server to the project directory
- Ensure URL rewriting is enabled (if using .htaccess)
- Set proper file permissions

## 📁 Project Structure

```
Online_Od/
├── assets/                 # Static assets (logos, images)
├── Database/              # Database schema and data
│   ├── online_od.sql     # Main database schema
│   └── online_od (1).sql # Backup schema
├── uploads/               # File uploads directory
│   └── [student_folders]/ # Individual student upload folders
├── vendor/                # Composer dependencies
│   ├── phpmailer/        # Email functionality
│   └── tecnickcom/       # PDF generation
├── admin_profile.php     # Admin profile management
├── attendance.php        # Attendance tracking
├── career_guidance_form.php # Career guidance form
├── dean_dashboard.php    # Dean's dashboard
├── hod_dashboard.php     # HOD's dashboard
├── index.php            # Main landing page
├── login.php            # Authentication system
├── od_form.php          # OD application form
├── student_dashboard.php # Student dashboard
├── teacher_dashboard.php # Teacher dashboard
├── vc_dashboard.php     # Vice Chancellor dashboard
├── db.php               # Database connection
├── composer.json        # PHP dependencies
└── README.md           # This file
```

## 🔐 Authentication & Security

### Login Process
1. **Role Selection**: Users select their role (Student, Teacher, HOD, Dean, VC)
2. **Credential Verification**: System validates credentials based on role
3. **OTP Generation**: 6-digit OTP sent via email
4. **Session Creation**: Secure session established after OTP verification

### Security Features
- **Password Hashing**: Secure password storage
- **Session Management**: Secure session handling
- **Input Validation**: Comprehensive form validation
- **File Upload Security**: Type and size restrictions
- **SQL Injection Prevention**: Prepared statements
- **XSS Protection**: Output escaping

## 📊 Database Schema

### Core Tables

#### `users`
- User authentication and profile information
- Role-based access control
- Department assignments

#### `leave_applications`
- OD application details
- Document file paths
- Approval workflow status
- Timestamps and metadata

### Key Relationships
- Users → Departments (Many-to-One)
- Applications → Users (Many-to-One)
- Applications → Departments (Many-to-One)

## 🔄 Application Workflow

### OD Application Process
1. **Student Submission**: Fill form and upload documents
2. **Dean Review**: Initial review and forwarding
3. **HOD Approval**: Department-level approval
4. **Teacher Assignment**: Attendance marking assignment
5. **Final Approval**: Complete approval process

### Career Guidance Process
1. **Form Submission**: Student completes career guidance form
2. **Data Collection**: System stores preferences and interests
3. **Report Generation**: Analytics for career planning

## 📧 Email Notifications

The system sends automated emails for:
- **OTP Verification**: Login authentication
- **Application Status**: Approval/rejection notifications
- **New Applications**: Notify relevant authorities
- **Confirmation**: Application submission confirmations

## 📈 Reporting & Analytics

### Available Reports
- **Department-wise Statistics**: Application counts and approval rates
- **Individual Application Details**: Complete application information
- **PDF Export**: Downloadable reports for record keeping
- **Real-time Analytics**: Live dashboard statistics

### Export Features
- **PDF Generation**: Using TCPDF library
- **Filtered Reports**: Based on date, department, status
- **Summary Statistics**: Overall system performance metrics

## 🛠️ API Endpoints

### Core Endpoints
- `GET /index.php` - Main landing page
- `POST /login.php` - Authentication
- `GET /otp_verification.php` - OTP verification
- `POST /od_form.php` - OD application submission
- `GET /career_guidance_form.php` - Career guidance form

### Dashboard Endpoints
- `GET /student_dashboard.php` - Student dashboard
- `GET /teacher_dashboard.php` - Teacher dashboard
- `GET /hod_dashboard.php` - HOD dashboard
- `GET /dean_dashboard.php` - Dean dashboard
- `GET /vc_dashboard.php` - VC dashboard

## 🎨 UI/UX Features

### Design Principles
- **Responsive Design**: Mobile-first approach
- **Intuitive Navigation**: Clear user interface
- **Consistent Branding**: PTU color scheme and logo
- **Accessibility**: Screen reader friendly

### Color Scheme
- **Primary**: #001f3f (Dark Blue)
- **Secondary**: #c40d0d (Red)
- **Accent**: #ffe6e6 (Light Pink)
- **Text**: #000000 (Black)

## 🔧 Configuration Options

### Email Settings
```php
// SMTP Configuration
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
```

### File Upload Settings
```php
// Upload Configuration
$max_size = 5 * 1024 * 1024; // 5MB limit
$allowed_extensions = ['pdf', 'jpg', 'jpeg', 'png'];
```

### Session Configuration
```php
// Session Security
session_start();
session_regenerate_id(true);
```

## 🚨 Troubleshooting

### Common Issues

#### Database Connection Error
```bash
# Check database credentials in db.php
# Ensure MySQL service is running
# Verify database exists
```

#### Email Not Sending
```bash
# Check SMTP credentials
# Verify app-specific password for Gmail
# Check firewall settings
```

#### File Upload Issues
```bash
# Check uploads/ directory permissions
# Verify PHP upload settings in php.ini
# Check file size limits
```

#### Session Issues
```bash
# Check session directory permissions
# Verify session configuration
# Clear browser cookies
```

## 🔄 Updates & Maintenance

### Regular Maintenance Tasks
1. **Database Backups**: Regular backup of MySQL database
2. **Log Monitoring**: Check error logs for issues
3. **File Cleanup**: Remove old uploaded files
4. **Security Updates**: Keep dependencies updated

### Update Process
1. **Backup**: Create full system backup
2. **Update Code**: Pull latest changes
3. **Database Migration**: Run any new migrations
4. **Test**: Verify functionality
5. **Deploy**: Update production system

## 📞 Support & Contact

### Technical Support
- **Email**: yourgmail@gmail.com
- **Department**: IT Team
- **University**: Puducherry Technological University

### Documentation
- **User Manual**: Available in system help section
- **API Documentation**: Contact IT team
- **Training Materials**: Provided during system rollout

## 📄 License

This project is developed for Puducherry Technological University and is proprietary software. All rights reserved.

## 🤝 Contributing

This is an internal university system. For contributions or improvements, please contact the IT department at Puducherry Technological University.

## 📝 Changelog

### Version 1.0.0 (Current)
- Initial release of PTU Advanced Portal
- Complete OD management system
- Career guidance form integration
- Multi-role authentication
- Email notification system
- PDF report generation
- Responsive web design

---

**Developed by**: PTU IT Team  
**Maintained by**: Students of PTU  
**Location**: Puducherry Technological University, Puducherry - 605014 
