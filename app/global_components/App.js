import React from "react";
import ReactDOM from "react-dom";
import Sidebar_view from "./sidebar_componets";

const App = () => {
  const projName = "Your Project Name"; // Replace with your actual project name
  const username = "Marc Buday"; // Replace with the actual username
  const roleName = "Admin"; // Replace with the actual role

  return (
    <div className="flex flex-row min-w-screen h-screen">
      <Sidebar_view
        proj_name={projName}
        username={username}
        role_name={roleName}
      />
      {/* Rest of your main content */}
      <div className="min-w-screen min-h-screen">
        {/* Your main content goes here */}
      </div>
    </div>
  );
};

ReactDOM.render(<App />, document.getElementById("root"));
