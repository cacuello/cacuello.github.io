import React from "react";

const trips = [
  {
    id: "5001",
    from: "Dumaguete Port",
    to: "Siquijor Port",
    date: "2026-04-15",
    time: "1:30 PM",
  },
  {
    id: "5002",
    from: "Dumaguete Port",
    to: "Bohol Tagbilaran",
    date: "2026-04-11",
    time: "2:30 PM",
  },
];

function TripList() {
  return (
    <div>
      <h2>Trips</h2>
      <table border="1" cellPadding="10">
        <thead>
          <tr>
            <th>Trip ID</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Date</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          {trips.map((trip) => (
            <tr key={trip.id}>
              <td>{trip.id}</td>
              <td>{trip.from}</td>
              <td>{trip.to}</td>
              <td>{trip.date}</td>
              <td>{trip.time}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default TripList;