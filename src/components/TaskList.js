import React, { useState } from "react";

const initialTasks = [
  { id: 256, name: "Check-in", status: "Pending" },
  { id: 257, name: "Pay Ticket", status: "Completed" },
  { id: 245, name: "Upload ID", status: "Pending" },
];

function TaskList() {
  const [tasks, setTasks] = useState(initialTasks);

  const toggleStatus = (id) => {
    const updated = tasks.map((task) =>
      task.id === id
        ? {
            ...task,
            status: task.status === "Pending" ? "Completed" : "Pending",
          }
        : task
    );
    setTasks(updated);
  };

  return (
    <div>
      <h2>Tasks</h2>
      <table border="1" cellPadding="10">
        <thead>
          <tr>
            <th>Task ID</th>
            <th>Task Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          {tasks.map((task) => (
            <tr key={task.id}>
              <td>{task.id}</td>
              <td>{task.name}</td>
              <td>{task.status}</td>
              <td>
                <button onClick={() => toggleStatus(task.id)}>
                  Toggle
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default TaskList;