<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---
## Weather API App

Weather API App is a web application built with Angular frontend and Laravel backend that allows users to view current weather data for multiple cities. The application is secured using Auth0 authentication with Multi-Factor Authentication (MFA).

### Features

- User authentication using Auth0.
- Multi-Factor Authentication via email or push notification.
- Restricted login (public signups disabled).
- Fetches real-time weather data from OpenWeatherMap API.
- Displays weather with temperature, status, and icons.
- Responsive design using CSS Grid.

### Tech Stack

- Frontend: Angular 17, TypeScript, HTML, CSS
- Backend:Laravel 10, PHP 8+
- Authentication: Auth0 (OAuth2, JWT),MFA
- Weather Data:OpenWeatherMap API
- Database:(Optional) MySQL for caching weather data
- Other:RxJS for HTTP calls, Observables
- POSTMAN : Used to test the api endpoints before actually depends on website.

---
## Setup Instructions

 *****Backend Laravel****

1.Create the app called  "Fidenz - Weather API App".
2.Move back to "Fidenz - Weather API App" by using cd.
3.Then created backend folder and same process is done for Frontend also.
4.Intalled Composer Libraries.
5.Created to store .env file to openweathermap api key.
6.Then run php laravel migrate to check database for caching using php artisan migrate.
7.Started the Server using php artisan serve.

****Frontend****
1.Same Like Backend.
2.Install angular libraries using  npm install -g @angular/cli
3.Then created frontend folder and Started the angular server using ng serve --open.

*****Authentication****
1.Before login into site first should verify themselves into an app that using MFA called Guardian.
2.Then you can enter the Login Credentials and click continue.
3.User will promptly asked the verification code to access to the weather data.
4.If login success -> Shows data if not -> not authentication is failed.

*****Weather Data ****
1.It will shows the data with CityCode with current status and temperation.
2.You can logout whenever needed and again proceed with same steps that asked in authentication.

*****GitHub Creation****
1.Git Status to view status.
2.Create a repo in GitHub
3.Add the frontend + backend files to same folder or repo.
4.Had a several committed messages stating each task done.
5.Then finally push it to GitHub.
6.I followed these steps once my per task done.


### Backend (Laravel)

1. Clone the repository:
```bash
git clone <your-repo-link>
cd "Fidenz - Weather API App/backend"
