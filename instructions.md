# 📋 Complete Project Instructions

## AI-Powered Smart City Complaint & Issue Resolution System

---

## 🎯 Project Overview

This comprehensive web-based platform revolutionizes civic issue reporting through intelligent automation, real-time tracking, and GIS-powered visualization. The system transforms manual, inefficient processes into a streamlined, transparent workflow for smart city governance.

---

## 📋 Table of Contents

1. [Prerequisites](#prerequisites)
2. [Installation Guide](#installation-guide)
3. [Configuration](#configuration)
4. [Database Setup](#database-setup)
5. [API Configuration](#api-configuration)
6. [Running the Application](#running-the-application)
7. [User Roles & Access](#user-roles--access)
8. [Testing Guide](#testing-guide)
9. [Troubleshooting](#troubleshooting)
10. [Deployment](#deployment)
11. [Maintenance](#maintenance)

---

## 📋 Prerequisites

### System Requirements

#### Software Requirements
- **Operating System**: Windows 10/11, macOS, or Linux
- **Web Server**: Apache 2.4+ (included in XAMPP)
- **Database**: MySQL 8.0+ (included in XAMPP)
- **PHP**: Version 8.0 or higher
- **Browser**: Modern browser (Chrome, Firefox, Safari, Edge)

#### Hardware Requirements
- **RAM**: Minimum 4GB, Recommended 8GB+
- **Storage**: 500MB free space for application + uploads
- **Internet**: Required for AI classification and map tiles

### Required Software Installation

#### 1. XAMPP Installation
1. Download XAMPP from [apachefriends.org](https://www.apachefriends.org/)
2. Install XAMPP in default location (`C:\xampp`)
3. Ensure Apache and MySQL modules are selected during installation

#### 2. PHP Extensions
Ensure these PHP extensions are enabled in `php.ini`:
- `curl` (for API calls)
- `pdo_mysql` (for database)
- `mbstring` (for Unicode support)
- `fileinfo` (for file uploads)
- `gd` (for image processing)

#### 3. Optional Tools
- **Composer**: For PHP dependency management
- **Git**: For version control
- **Visual Studio Code**: Recommended IDE

---

## 🚀 Installation Guide

### Step 1: Project Setup

1. **Download/Clone the Project**
   ```bash
   # If using Git
   git clone <repository-url>
   cd SM-City

   # Or extract ZIP file to:
   # C:\xampp\htdocs\SM-City
   ```

2. **Verify Project Structure**
   ```
   SM-City/
   ├── database/
   │   └── schema.sql
   ├── public/
   │   └── index.php
   ├── src/
   │   ├── Controllers/
   │   ├── Models/
   │   ├── Views/
   │   └── Core/
   ├── uploads/
   └── README.md
   ```

### Step 2: Start XAMPP Services

1. **Launch XAMPP Control Panel**
   - Run `xampp-control.exe` as Administrator

2. **Start Required Services**
   - Click "Start" next to Apache
   - Click "Start" next to MySQL
   - Verify both show green status

3. **Test Services**
   - Apache: http://localhost
   - MySQL: http://localhost/phpmyadmin

---

## ⚙️ Configuration

### Step 3: Environment Configuration

1. **Create Environment File**
   ```bash
   # Copy the example file
   copy .env.example .env
   ```

2. **Edit .env File**
   ```env
   # Database Configuration
   DB_HOST=localhost
   DB_NAME=sm_city
   DB_USER=root
   DB_PASS=

   # AI Configuration
   OPENAI_API_KEY=your_openai_api_key_here

   # Application Settings
   APP_URL=http://localhost/SM-City/public
   APP_NAME="SM City Complaint System"

   # Security Settings
   APP_KEY=your_random_app_key_here
   ```

### Step 4: Database Setup

1. **Create Database**
   - Open phpMyAdmin: http://localhost/phpmyadmin
   - Click "New" in left sidebar
   - Database name: `sm_city`
   - Collation: `utf8mb4_unicode_ci`
   - Click "Create"

2. **Import Schema**
   - Select `sm_city` database
   - Click "Import" tab
   - Choose file: `database/schema.sql`
   - Click "Go"

3. **Verify Tables**
   - Check these tables are created:
     - `users`
     - `complaints`
     - `complaint_history`

---

## 🔑 API Configuration

### OpenAI API Setup

1. **Get API Key**
   - Visit: https://platform.openai.com/api-keys
   - Sign up/Login to OpenAI account
   - Create new API key
   - Copy the key

2. **Configure API Key**
   - Add to `.env` file:
   ```env
   OPENAI_API_KEY=sk-your-actual-api-key-here
   ```

3. **Test API Connection**
   - The system will automatically test during first complaint submission
   - Falls back to keyword matching if API unavailable

---

## 🎯 Running the Application

### Step 5: Access the Application

1. **Open Browser**
   ```
   URL: http://localhost/SM-City/public
   ```

2. **Initial Setup**
   - Register first admin user with role "admin"
   - Create test accounts for different roles

### Step 6: Create Test Users

#### Admin User Creation
```php
// Run this in browser or create script
http://localhost/SM-City/create_admin.php
```

#### Manual User Registration
1. Visit registration page
2. Create accounts with different roles:
   - **Admin**: role = "admin"
   - **Officer**: role = "officer"
   - **Citizen**: role = "citizen" (default)

---

## 👥 User Roles & Access

### 1. Citizen Role
**Capabilities:**
- Register and login
- Submit complaints with photos and location
- Track complaint status
- View personal dashboard
- Edit profile

**Access URL:** `/citizen/dashboard`

### 2. Officer Role
**Capabilities:**
- View assigned complaints
- Update complaint status
- Upload resolution evidence
- Access authority dashboard
- Manage complaint workflow

**Access URL:** `/authority/dashboard`

### 3. Admin Role
**Capabilities:**
- Full system access
- View analytics and reports
- Manage all users and complaints
- System configuration
- Access admin dashboard

**Access URL:** `/admin/dashboard`

---

## 🧪 Testing Guide

### Functional Testing

#### 1. User Registration & Authentication
- [ ] Register new citizen account
- [ ] Login/logout functionality
- [ ] Password reset (if implemented)
- [ ] Role-based access control

#### 2. Complaint Submission
- [ ] Create complaint with text description
- [ ] Upload image attachment
- [ ] Select location on map
- [ ] GPS location detection
- [ ] Form validation

#### 3. AI Classification Testing
- [ ] Submit complaints with different categories:
  - "garbage overflow on street"
  - "pothole on main road"
  - "water leaking from pipe"
  - "drainage blocked"
  - "streetlight not working"
- [ ] Verify automatic categorization
- [ ] Check priority assignment
- [ ] Test duplicate detection

#### 4. Authority Operations
- [ ] Login as officer/admin
- [ ] View complaint details
- [ ] Update status (In Progress, Resolved, etc.)
- [ ] Upload resolution evidence
- [ ] Verify status changes

#### 5. Admin Dashboard
- [ ] View statistics and charts
- [ ] Check complaint analytics
- [ ] Test map visualization
- [ ] Verify user management

### Performance Testing

#### Load Testing
- [ ] Multiple simultaneous users
- [ ] Large file uploads
- [ ] Concurrent complaint submissions
- [ ] Database query performance

#### Security Testing
- [ ] SQL injection attempts
- [ ] XSS vulnerability checks
- [ ] CSRF protection verification
- [ ] File upload security

---

## 🔧 Troubleshooting

### Common Issues

#### 1. Apache/MySQL Won't Start
**Symptoms:** Services show red in XAMPP
**Solutions:**
- Check if ports 80/443 (Apache) and 3306 (MySQL) are free
- Run XAMPP as Administrator
- Check Windows Firewall settings
- Restart computer

#### 2. Database Connection Error
**Symptoms:** "Database connection failed"
**Solutions:**
- Verify MySQL service is running
- Check database credentials in `.env`
- Ensure database `sm_city` exists
- Test connection via phpMyAdmin

#### 3. File Upload Issues
**Symptoms:** Images not uploading
**Solutions:**
- Check `uploads/` directory permissions
- Verify PHP upload limits in `php.ini`
- Check file size and type restrictions
- Ensure GD extension is enabled

#### 4. AI Classification Not Working
**Symptoms:** Complaints not categorized
**Solutions:**
- Verify OpenAI API key in `.env`
- Check internet connection
- Review API key permissions
- Check fallback classification

#### 5. Map Not Loading
**Symptoms:** Interactive map not displaying
**Solutions:**
- Check internet connection for map tiles
- Verify JavaScript is enabled
- Check browser console for errors
- Test Leaflet.js loading

#### 6. Permission Errors
**Symptoms:** Access denied errors
**Solutions:**
- Set proper file permissions (755 for directories, 644 for files)
- Check Apache user permissions
- Verify `.htaccess` configuration

### Debug Mode

Enable debug mode by adding to `.env`:
```env
APP_DEBUG=true
```

This will show detailed error messages for troubleshooting.

---

## 🚀 Deployment

### Production Deployment

#### 1. Web Server Setup
- **Apache/Nginx**: Configure virtual host
- **SSL Certificate**: Enable HTTPS
- **Domain**: Point domain to server

#### 2. Database Migration
- Export local database
- Import to production server
- Update connection credentials

#### 3. File Permissions
```bash
# Set proper permissions
chmod 755 /var/www/html/SM-City
chmod 644 /var/www/html/SM-City/*.php
chmod 777 /var/www/html/SM-City/uploads
```

#### 4. Environment Configuration
- Update `.env` with production values
- Set `APP_DEBUG=false`
- Configure production database

#### 5. Security Hardening
- Change default passwords
- Enable firewall rules
- Configure SSL/TLS
- Set up regular backups

### Cloud Deployment Options

#### AWS EC2
1. Launch EC2 instance with Amazon Linux
2. Install LAMP stack
3. Upload project files
4. Configure security groups

#### Heroku
1. Create Heroku app
2. Add ClearDB MySQL add-on
3. Deploy via Git
4. Configure environment variables

#### DigitalOcean
1. Create Droplet with LAMP
2. Upload files via SFTP
3. Configure domain and SSL

---

## 🔧 Maintenance

### Regular Tasks

#### 1. Database Backup
```bash
# Daily backup script
mysqldump -u root -p sm_city > backup_$(date +%Y%m%d).sql
```

#### 2. File Cleanup
- Remove old uploaded files periodically
- Clear temporary files
- Archive resolved complaints

#### 3. Performance Monitoring
- Monitor database query performance
- Check server resource usage
- Review error logs regularly

#### 4. Security Updates
- Keep PHP and MySQL updated
- Monitor for security vulnerabilities
- Regular security audits

### Log Management

#### Application Logs
- Check PHP error logs: `/xampp/php/logs/php_error_log`
- Apache access/error logs: `/xampp/apache/logs/`
- Application-specific logs in project directory

#### Database Logs
- MySQL error log: `/xampp/mysql/data/mysql_error.log`
- Slow query log (if enabled)

### Updates & Upgrades

#### System Updates
1. Backup entire application
2. Update PHP version carefully
3. Test all functionality after updates
4. Update dependencies if using Composer

#### Feature Updates
1. Pull latest code changes
2. Run database migrations if any
3. Test new features thoroughly
4. Update documentation

---

## 📞 Support & Resources

### Documentation
- [README.md](README.md) - Project overview
- [tech-stack.md](tech-stack.md) - Technology details
- [problem-statement.md](problem-statement.md) - Problem analysis
- [Solution.md](Solution.md) - Solution architecture
- [Core-modules.md](Core-modules.md) - Implementation status

### External Resources
- **PHP Documentation**: https://www.php.net/docs.php
- **MySQL Manual**: https://dev.mysql.com/doc/
- **OpenAI API Docs**: https://platform.openai.com/docs
- **Leaflet.js Guide**: https://leafletjs.com/reference.html

### Community Support
- GitHub Issues for bug reports
- Stack Overflow for technical questions
- PHP/MySQL forums for general help

---

## 🎯 Quick Reference

### Important URLs
- **Application**: http://localhost/SM-City/public
- **phpMyAdmin**: http://localhost/phpmyadmin
- **XAMPP Control**: Run xampp-control.exe

### Key Files
- **Entry Point**: `public/index.php`
- **Configuration**: `.env`
- **Database Schema**: `database/schema.sql`
- **Bootstrap**: `src/bootstrap.php`

### Default Credentials
- **Database**: root / (empty password)
- **Admin Creation**: Run `create_admin.php`

---

**🎉 Your AI-Powered Smart City Complaint System is now ready!**

For additional help, refer to the detailed documentation or create an issue in the project repository.

*Developed by Samarth P*
