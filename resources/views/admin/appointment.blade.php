@extends('admin.home')
@section('appointment')
    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Appointment - MediCare</title>
  <style>
    body { font-family: Arial; background: #f4f4f4; margin: 0; }
    
    
    .container { padding: 20px; }
    h1 { color: #0077b6; }
    form { display: flex; flex-direction: column; gap: 10px; margin-top: 20px; }
    input, select, textarea, button {
      padding: 10px;
      font-size: 1rem;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button { background: #0089b6ff; color: white; border: none; cursor: pointer; }
    button:hover { background: #0096c7; }
  </style>
</head>
<body>
  
  <div class="container">
    <h1>Book an Appointment</h1>
    <form>
      <input type="text" placeholder="Your Name" required />
      <input type="email" placeholder="Email" required />
      <input type="date" required />
      <select required>
        <option value="">Select Doctor</option>
        <option>Dr. Ayesha Karim</option>
        <option>Dr. Tanvir Ahmed</option>
        <option>Dr. Fayez Salehin</option>
        <option>Dr. Rakib Bhuiyan</option>
        <option>Dr. Shihab </option>
        <option>Dr. Jemsbon</option>
        <option>Dr. Dr.Hablu Maham</optino>
        <option>Dr. Shreare</option>
      </select>
      <textarea rows="4" placeholder="Describe your issue..."></textarea>
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>
@endsection