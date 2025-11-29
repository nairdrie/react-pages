# WordPress React Pages Plugin

A high-performance WordPress plugin designed to seamlessly integrate multiple React Single Page Applications (SPAs) into a WordPress environment. 

It supports two modes of integration: **Embedded Widgets** (via Shortcodes) and **Full-Page Takeovers** (bypassing the active theme entirely).

## 🚀 Key Features

* **Multi-App Support:** Host multiple distinct React applications (e.g., Dashboards, Calculators, Portals) within a single plugin.
* **Theme Bypass (Canvas Mode):** Optionally disable the WordPress theme (Headers, Footers, Sidebars) for specific URLs to give your React app 100% of the screen real estate.
* **Vite Optimization:** Designed to work with modern Vite builds using static filenames.
* **Asset Management:** Automatically handles dependency registration and enqueueing.
* **Selective Loading:** Scripts are only loaded on the specific pages where they are needed, preserving global site performance.

## 📂 Project Structure

This plugin expects the following directory structure to function correctly:

```text
wp-content/plugins/react-pages/
├── react-pages.php              # Main Plugin File (Logic & Enqueueing)
├── templates/
│   └── app-canvas.php           # Blank HTML shell for Theme Bypass
├── fraud-detection/             # React App #1
│   └── dist/
│       └── assets/
│           ├── app.js           # Built JS
│           └── main.css         # Built CSS
└── financial-forecasting/       # React App #2
    └── dist/
        └── assets/
            ├── app.js
            └── main.css