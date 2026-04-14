import React from "react";
import PassengerList from "./components/PassengerList";
import TripList from "./components/TripList";
import TaskList from "./components/TaskList";
import NotificationList from "./components/NotificationList";
import './App.css';

function App() {
  return (
    <div style={{ padding: "20px" }}>
      <h1>⛵ SailPlan: Passenger Task Manager</h1>

      <PassengerList />
      <TripList />
      <TaskList />
      <NotificationList />
    </div>
  );
}

export default App;