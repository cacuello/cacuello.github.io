import React from "react";

const notifications = [
  { id: 101, msg: "Reminder: Check-in", status: "Unread" },
  { id: 105, msg: "Payment Received", status: "Read" },
  { id: 103, msg: "Reminder: Payment", status: "Unread" },
];

function NotificationList() {
  return (
    <div>
      <h2>Notifications</h2>
      <table border="1" cellPadding="10">
        <thead>
          <tr>
            <th>ID</th>
            <th>Message</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          {notifications.map((n) => (
            <tr key={n.id}>
              <td>{n.id}</td>
              <td>{n.msg}</td>
              <td>{n.status}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default NotificationList;