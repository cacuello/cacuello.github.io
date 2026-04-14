import React from "react";

const passengers = [
  {
    id: "001",
    name: "Marayan, Mylene J.",
    email: "mjmarayan@gmail.com",
    contact: "09059343525",
  },
  {
    id: "002",
    name: "Alde, Maikie B.",
    email: "maikiealde@gmail.com",
    contact: "09691803887",
  },
];

function PassengerList() {
  return (
    <div>
      <h2>Passengers</h2>
      <table border="1" cellPadding="10">
        <thead>
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Contact</th>
          </tr>
        </thead>
        <tbody>
          {passengers.map((p) => (
            <tr key={p.id}>
              <td>{p.id}</td>
              <td>{p.name}</td>
              <td>{p.email}</td>
              <td>{p.contact}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default PassengerList;