<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>

    <link rel="stylesheet" href="{{ asset('css/doctor-profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="profile-card">
    <div class="profile-header">
        <img src="{{ asset('images/rakib.jpg') }}" alt="Doctor Photo" class="profile-photo">
        <div class="profile-info">
            <h2>Dr. Rakibul Hasan</h2>
            <p><span class="icon"><i class="fa-solid fa-cake-candles"> </i></span>  22 Years</p>
            <p><span class="icon"><i class="fa-solid fa-phone"></i> </span> +880 1316787455</p>
            <p><span class="icon"><i class="fa-solid fa-location-dot"></i></span> Ali Hossen Bari ,Oxyzen,Bayezid , Chittagong</p>
            <p><span class="icon"><i class="fa-solid fa-earth-asia"></i></span> Bangladesh</p>
        </div>
        <div class="profile-actions">
            <button class="btn share"><i class="fa-solid fa-link"></i></button>
            <button class="btn download"><i class="fa-solid fa-download"></i></button>
        </div>
    </div>

    <div class="tabs">
        <button class="tab active" onclick="switchTab('personal')">Personal Details</button>
        <button class="tab" onclick="switchTab('appointment')">Appointment Details</button>
    </div>

    <div id="personal" class="tab-content active">
        <div class="form-grid">
            <div>
                <label>Date of Joining</label>
                <input type="text" value="01 - Jan - 2012" readonly>
            </div>
            <div>
                <label>Date of Birth</label>
                <input type="text" value="01 - Mar - 1984" readonly>
            </div>
            <div>
                <label>Blood Group</label>
                <select disabled>
                    <option>A+</option>
                </select>
            </div>
            <div>
                <label>Email Address</label>
                <input type="email" value="messy.william@gmail.com" readonly>
            </div>
            <div>
                <label>Specialist</label>
                <div class="tags">
                    <span>Cardiomyopathy</span>
                    <span>Arrhythmia</span>
                    <span>Hypertension</span>
                </div>
            </div>
            <div>
                <label>Department</label>
                <select disabled>
                    <option>Cardiology</option>
                </select>
            </div>
            <div>
                <label>Designation</label>
                <div class="tags">
                    <span>MD - Medicine</span>
                    <span>DM - Cardiology</span>
                </div>
            </div>
            <div>
                <label>Work Experience</label>
                <input type="text" value="15 Years" readonly>
            </div>
        </div>
    </div>

    <div id="appointment" class="tab-content">
    <table class="appointment-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Doctor Details</th>
                <th>Status</th>
                <th>Attachment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="date">5 Dec 2019</div>
                    <div class="time">4.30 PM</div>
                </td>
                <td>
                    <div class="doctor-info">
                        <img src="{{ asset('images/doc1.jpg') }}" alt="">
                        <span>Petunia Dusley</span>
                    </div>
                </td>
                <td><span class="status visited">Visited</span></td>
                <td><a href="#"><i class="fa-solid fa-link"></i></a></td>
                <td class="actions">
                    <a href="#"><i class="fa-solid fa-share-nodes"></i></a>
                    <a href="#"><i class="fa-solid fa-download"></i></a>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="date">2 Dec 2019</div>
                    <div class="time">2.30 PM</div>
                </td>
                <td>
                    <div class="doctor-info">
                        <img src="{{ asset('images/doc2.jpg') }}" alt="">
                        <span>Aishley Trciton</span>
                    </div>
                </td>
                <td><span class="status visited">Visited</span></td>
                <td><a href="#"><i class="fa-solid fa-link"></i></a></td>
                <td class="actions">
                    <a href="#"><i class="fa-solid fa-share-nodes"></i></a>
                    <a href="#"><i class="fa-solid fa-download"></i></a>
                    
                </td>
            </tr>

            <tr>
                <td>
                    <div class="date">28 Nov 2019</div>
                    <div class="time">7.00 PM</div>
                </td>
                <td>
                    <div class="doctor-info">
                        <img src="{{ asset('images/doc3.jpg') }}" alt="">
                        <span>Edward Norman</span>
                    </div>
                </td>
                <td><span class="status cancelled">Cancelled</span></td>
                <td><a href="#"><i class="fa-solid fa-link"></i></a></td>
                <td class="actions">
                    <a href="#"><i class="fa-solid fa-share-nodes"></i></a>
                    <a href="#"><i class="fa-solid fa-download"></i></a>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="date">22 Nov 2019</div>
                    <div class="time">9.30 AM</div>
                </td>
                <td>
                    <div class="doctor-info">
                        <img src="{{ asset('images/doc1.jpg') }}" alt="">
                        <span>Petunia Dusley</span>
                    </div>
                </td>
                <td><span class="status visited">Visited</span></td>
                <td><a href="#"><i class="fa-solid fa-link"></i></a></td>
                <td class="actions">
                    <a href="#"><i class="fa-solid fa-share-nodes"></i></a>
                    <a href="#"><i class="fa-solid fa-download"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>

<script src="{{ asset('js/doctor-profile.js') }}"></script>
</body>
</html>
