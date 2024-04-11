# Project Features Overview

This document outlines additional functionality integrated into our web application to enhance user experience and provide valuable insights to administrators.

## Features

### Tracking Post Clicks

- **Frontend**: Utilizes JavaScript to attach event listeners to post elements. Upon clicking a post, an AJAX request is sent to the server carrying the post ID.
- **Backend**: A PHP script (`record_click.php`) processes the AJAX request, recording each click in the `post_clicks` table in the database. This data is used to highlight the most clicked posts among all.

### Accessibility: Dark Theme

- **Objective**: To accommodate users with visual impairments and sensitivity to bright screens, we've implemented a dark theme toggle.
- **Implementation**:
  - **HTML**: Adds a toggle button on the home page.
  - **CSS**: Defines styles for both light and dark modes.
  - **JavaScript**: Toggles the dark mode and remembers the user's preference to ensure a consistent experience across different pages.

### Activity By Date

- **Functionality**: Records the time users log into the website, displaying their login time prominently.
- **Purpose**: To engage users by providing them with personalized information regarding their activity on the site.

### Alert on Pages

- **Description**: Briefly displays a popup notification on the page to inform users about the page they are currently viewing.
- **Technologies**:
  - **HTML**: Serves as the framework for detecting user clicks.
  - **CSS**: Styles the popup notification.
  - **JavaScript**: Manages the display and automatic hiding of the popup after a short duration.

### Admin View Reports on Usage

- **Feature**: Enables administrators to view reports on user activity, specifically focusing on the number of active users.
- **Implementation**:
  - **Frontend**: Uses HTML to display the count of active users.
  - **Backend**: A PHP function queries the database to retrieve the active user count, ensuring admins have up-to-date information on user engagement.

## Future Enhancments

Our current implementation, including features such as tracking post clicks and generating usage reports, is optimized for low to moderate traffic websites. 

## Reasons for Optimization
Server Load: Increased traffic results in more concurrent requests for the server to handle, which can lead to slower response times and potentially overload the server.

## Future Enhancements
Load Balancing: Distribute incoming network traffic across multiple servers to ensure no single server becomes overwhelmed, improving responsiveness and availability.

