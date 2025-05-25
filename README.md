# Laravel Job Portal

A robust job portal application built with Laravel that enables users to effortlessly post job listings, browse and filter opportunities by keyword, category, and location, and apply directly through the platform. The project features user authentication, job CRUD operations, dynamic search and filter functionality, category-based navigation, and real-time notifications, making it an ideal foundation for any recruitment or career management system.

## Features

* **User Registration & Authentication**: Secure login and registration for job seekers and employers.
* **Job Posting**: Employers can create, edit, and delete job listings with detailed descriptions.
* **Job Search & Filter**: Dynamic search bar and filter options by category, location, and keywords.
* **Job Categories**: Browse jobs organized into customizable categories.
* **Apply for Jobs**: Job seekers can submit applications directly from the job detail page.
* **Dashboard**: Management dashboard for users to view and manage their postings and applications.

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/Laravel-Job-Portal.git
   cd Laravel-Job-Portal
   ```
2. Install dependencies:

   ```bash
   composer install
   npm install && npm run dev
   ```
3. Set up environment variables:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Configure your database in `.env`, then run migrations and seeders:

   ```bash
   php artisan migrate --seed
   ```
5. Serve the application:

   ```bash
   php artisan serve
   ```

## Usage

* Visit the home page to search and filter available jobs.
* Register or log in to post new job listings or apply for existing ones.
* Access your dashboard to manage your job postings or applications.

## Contributing

Contributions are welcome! Please fork the repository and open a pull request with your changes.

