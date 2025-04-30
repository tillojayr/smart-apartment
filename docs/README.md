# Smart Apartment Management System

A Laravel-based web application for managing smart apartments with real-time electricity monitoring and control features.

## Table of Contents

- [Features](#features)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [System Architecture](#system-architecture)
- [Key Components](#key-components)
- [API Documentation](#api-documentation)

## Features

- **User Authentication & Authorization**
  - Secure login system
  - Role-based access control (Apartment owners)
  - Profile management

- **Tenant Management**
  - Add/Edit tenant information
  - Track tenant occupancy
  - Manage tenant electric bills
  - Set budget limits for electricity consumption
  - Track payment history

- **Real-time Monitoring**
  - Live electricity consumption tracking
  - Voltage monitoring
  - Current monitoring
  - Power consumption analytics

- **Smart Control Panel**
  - Remote outlet control
  - Remote lighting control
  - Room status monitoring
  - Emergency controls
  - Natural Language Control Interface

- **Visual Data Analytics**
  - Real-time graphical representations
  - Historical data analysis
  - Consumption trends
  - Cost analysis

- **Automated Notifications**
  - Budget limit alerts
  - Payment reminders
  - Consumption warnings
  - SMS notifications

## System Requirements

- PHP >= 8.1
- Laravel 11.x
- MySQL/MariaDB
- Node.js & NPM
- Composer
- WebSocket Server (Laravel Echo Server/Pusher)

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd smart-apartment
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Configure environment variables:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure database in .env:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smart_apartment
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations:
```bash
php artisan migrate
```

7. Build assets:
```bash
npm run build
```

8. Start the development server:
```bash
php artisan serve
```

## System Architecture

### Database Schema

#### Users Table
- Stores apartment owners' information
- Manages authentication
- Stores rate configuration

#### Rooms Table
- Stores room information
- Tracks tenant details
- Monitors electricity consumption
- Budget management
- Notification flags

#### Controls Table
- Manages room controls
- Tracks relay states
- Links rooms with control systems

#### Electric Variables Table
- Records real-time electricity data
- Stores historical consumption data
- Tracks voltage and current readings

### Key Components

#### Livewire Components

1. **Tenants Component**
- Manages tenant information
- Handles room assignments
- Processes payments
- Sets budgets and reminders

2. **Control Panel Component**
- Manages room controls
- Handles real-time switching
- Monitors room status
- Processes emergency controls

3. **Visual Data Component**
- Generates real-time charts
- Processes historical data
- Calculates consumption metrics
- Handles data visualization

#### Event System

1. **SwitchControlEvent**
- Handles real-time switch operations
- Manages relay state changes
- Broadcasts control updates

2. **Jobs**
- CheckReminderTimeJob: Handles scheduled notifications
- Processes budget alerts
- Manages SMS notifications

## API Documentation

### Data Controller Endpoints

1. **POST /api/data**
- Updates electricity consumption data
- Parameters:
  - roomId: Room identifier
  - voltage: Current voltage reading
  - current: Current amperage reading
  - consumed: Power consumption value

2. **POST /api/reminder-time**
- Sets reminder time for notifications
- Parameters:
  - apartmentId: Owner identifier
  - room_id: Room identifier
  - reminder_time: Scheduled time

3. **GET /api/chart-data**
- Retrieves visualization data
- Parameters:
  - owner_id: Owner identifier
  - room_id: Room identifier
  - start_date: Start of date range
  - end_date: End of date range

### Switch Controller Endpoints

1. **POST /api/switch**
- Controls room switches
- Parameters:
  - owner_id: Owner identifier
  - room_id: Room identifier
  - relay: Relay identifier
  - state: Switch state

2. **GET /api/state**
- Retrieves current switch states
- Parameters:
  - room_id: Room identifier
  - owner_id: Owner identifier

### NLP Controller Endpoints

1. **POST /api/nlp/command**
- Processes natural language commands
- Parameters:
  - message: Natural language command text
- Example requests:
  ```
  {"message": "Turn off light in Room 3"}
  {"message": "What's my electricity usage this week?"}
  {"message": "Set power budget to $50 for Room 1"}
  ```
- Response format:
  ```json
  {
    "success": true,
    "message": "Command processed successfully",
    "action": "Light turned off in Room 3",
    "data": {} // Optional data based on command type
  }
  ```

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
