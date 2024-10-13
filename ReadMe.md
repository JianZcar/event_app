## Setup Instructions

### 1. Install Dependencies
Make sure you have `npm` installed. Then, run the following command to install the required dependencies:
```sh
npm install
```

### 2. Build Tailwind
To build the Tailwind CSS, run the following command:
```sh
npm run tailwind_build
```
### 3. Project Layout
Component Based Project.
Focused on Modularity and Cleanliness
```
project-root/
├── app/
│   ├── global_assets/
│   │   └── css/
│   │       └── input.css
│   │       └── output.css
│   ├── global_components/
│   │   └── header.php
│   │   └── footer.php
│   └── page
│       └── component/
│       └── assets/
│       └── index.php
├── index.php
├── package.json
├── tailwind.config.js
└── ReadMe.md
```