<<<<<<< HEAD
# AI-Powered Smart City Complaint & Issue Resolution System

## Setup Instructions

### Prerequisites
- XAMPP (Apache, MySQL, PHP)
- PHP 8+ with curl extension enabled
- Composer (optional, for dependencies)

### Installation Steps

1. **Clone or Extract the Project**
   - Place the project in `C:\xampp\htdocs\SM-City`

2. **Start XAMPP Services**
   - Open XAMPP Control Panel
   - Start Apache and MySQL

3. **Database Setup**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create database: `sm_city`
   - Import the schema from `database/schema.sql`

4. **Environment Configuration**
   - Copy `.env.example` to `.env` (if exists) or update `.env`
   - Set your database credentials
   - Add your OpenAI API key for AI classification

5. **Access the Application**
   - Open browser: http://localhost/SM-City/public
   - Register as a citizen or admin

### Features Implemented

- User authentication (Citizens, Officers, Admins)
- Complaint submission with image upload and location
- AI-powered classification using OpenAI API
- GIS visualization with Leaflet maps
- Complaint tracking and status updates
- Authority operations (status updates, resolution with evidence)

### API Keys Required

- **OpenAI API Key**: For intelligent complaint categorization
  - Get from: https://platform.openai.com/api-keys
  - Add to `.env`: `OPENAI_API_KEY=your_key_here`

### Default Credentials

- Admin: Register with role "admin"
- Officer: Register with role "officer"
- Citizen: Register with role "citizen"

### File Structure

```
SM-City/
├── database/
│   └── schema.sql          # Database schema
├── public/
│   └── index.php           # Front controller
├── src/
│   ├── bootstrap.php       # App bootstrap
│   ├── Controllers/        # MVC Controllers
│   ├── Core/               # Core classes (DB, Router)
│   ├── Models/             # Data models
│   ├── Services/           # Business logic (AI service)
│   └── Views/              # Templates
├── uploads/                # File uploads
├── .env                    # Environment config
└── README.md               # This file
```

### Technologies Used

- **Backend**: PHP 8+, MySQL
- **Frontend**: HTML5, TailwindCSS, JavaScript
- **Maps**: Leaflet.js with OpenStreetMap
- **AI**: OpenAI GPT API
- **Security**: CSRF protection, password hashing

### Development Notes

- The system uses MVC architecture
- AI classification falls back to keyword matching if OpenAI API is unavailable
- File uploads are stored in `uploads/` directory
- Sessions handle user authentication
- PDO for database interactions

### Future Enhancements

- Mobile app integration
- Advanced duplicate detection
- Real-time notifications
- Analytics dashboard
- Multilingual support
=======
# SM-CITY
>>>>>>> 45a00ea78c5b1694f73762bb3400211713485cb1
