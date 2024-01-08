# Business Timing Application

## Introduction

The Business Timing Application is a comprehensive web-based tool designed to streamline the management and display of operating hours, special closures, and images for different branches of your businesses. This application offers a user-friendly interface for creating, editing, and viewing the details of businesses and their branches.

## Table of Contents

- [Features](#features)
- [Getting Started](#getting-started)
  - [Installation](#installation)
  - [Usage](#usage)
- [Application Workflow](#application-workflow)
  - [Creating a Business](#creating-a-business)
  - [Adding a Branch](#adding-a-branch)
  - [Viewing Branch Details](#viewing-branch-details)
  - [Editing and Deleting Branches](#editing-and-deleting-branches)
  - [Closing Days and Special Closure Dates](#closing-days-and-special-closure-dates)
  - [Multiple Timings and Images](#multiple-timings-and-images)
- [Contributing](#contributing)
- [License](#license)

## Features

- **Business Management:**
  - Create and manage businesses with essential details.
  - Upload a logo for a professional appearance.

- **Branch Management:**
  - Add branches to businesses with customizable operating hours for each day of the week.
  - Specify multiple operating timings for a single day to accommodate various schedules.

- **Day-specific Closures:**
  - Mark specific days as closed for individual branches.
  - Easily manage and visualize the days when a branch is closed.

- **Special Closure Dates:**
  - Set special closure dates for branches to accommodate holidays or unique events.

- **Image Attachments:**
  - Attach multiple images to each branch to enhance the visual representation.

- **Detailed Information:**
  - View comprehensive details about each branch, including its business association, name, and status (open or closed).

- **Edit and Delete Functionality:**
  - Modify branch details or delete branches effortlessly as per your requirements.

## Getting Started

### Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/dkoderweb/Business-Timing.git
    ```

2. **Navigate to the project directory:**

    ```bash
    cd Business-Timing
    ```

3. **Install dependencies:**

    ```bash
    composer update
    ```

4. **Create a copy of the environment file:**

    ```bash
    cp .env.example .env
    ```

5. **Run the migrations:(Or you can use business.sql)**

    ```bash
    php artisan migrate
    ```

6. **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

7. **Create a symbolic link for the storage directory:**

    ```bash
    php artisan storage:link
    ```

8. **Run the development server:**

    ```bash
    php artisan serve
    ```

### Usage

Access the application in your web browser at [http://localhost:8000](http://localhost:8000).

## Application Workflow

### Creating a Business

1. Navigate to the business creation page.
2. Fill in the business details, including the name, email, phone number, and upload a logo.
3. Submit the form to create the business.

### Adding a Branch

1. After creating a business, navigate to the branches section.
2. Create a new branch for the selected business.
3. Specify the branch name, operating hours for each day of the week, and any special closure dates.
4. Attach multiple images to the branch.
5. Submit the form to add the branch.

### Viewing Branch Details

1. You can view the details of each branch, including the business it belongs to, name, status (open or closed), and operating hours for each day.

### Editing and Deleting Branches

1. You can edit the details of a branch or delete it if needed.
2. Editing includes updating business information, branch name, operating hours, and images.

### Closing Days and Special Closure Dates

1. When you mark a specific day as closed, it will be displayed as "Closed" in the branch details.

2. If a branch has special closure dates, it will be displayed as "Closed" on those specific dates.

### Multiple Timings and Images

1. You can add multiple operating timings for the same day.

2. Attach and manage multiple images for each branch.

## Contributing

Contributions are welcome! If you find any issues or have suggestions, please feel free to [create an issue](https://github.com/dkoderweb/Business-Timing/issues) or [submit a pull request](https://github.com/dkoderweb/Business-Timing/pulls).

## License

This project is licensed under the [MIT License](LICENSE).
