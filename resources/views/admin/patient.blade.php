@extends('admin.home')

@section('patient')
<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
    }
    h2 {
        margin-bottom: 10px;
    }
    .table-container {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
    }
    .controls {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }
    .controls select, .controls input {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    th, td {
        padding: 12px 10px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    th {
        background-color: #f9f9f9;
        cursor: pointer;
    }
    tr:hover {
        background-color: #f3f3f3;
    }
    .patient-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .patient-info img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }
    .progress-bar {
        width: 100%;
        height: 6px;
        background: #f0f0f0;
        border-radius: 4px;
        overflow: hidden;
        position: relative;
    }
    .progress {
        height: 100%;
        border-radius: 4px;
    }
    .progress.green { background: #28a745; width: 90%; }
    .progress.red { background: #dc3545; width: 30%; }
    .progress.blue { background: #007bff; width: 50%; }
    .status-btn {
        padding: 4px 10px;
        border: none;
        border-radius: 15px;
        font-size: 12px;
        color: white;
        cursor: pointer;
    }
    .admit { background-color: #17a2b8; }
    .discharge { background-color: #28a745; }
    .table-footer {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        font-size: 14px;
    }
    .pagination button {
        padding: 5px 10px;
        border: 1px solid #ccc;
        background: white;
        cursor: pointer;
    }
    .pagination .active {
        background-color: #28a745;
        color: white;
    }
</style>
    <h2>Patient Details</h2>

    <div class="table-container">
    <div class="controls">
        <div>
            Show 
            <select>
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select> entries
        </div>
        <div>
            Search: <input type="text">
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>PATIENTS</th>
                <th>ADRESS</th>
                <th>ADMITED</th>
                <th>DISCHARGE</th>
                <th>PROGRESS</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="patient-info">
                        <img src="{{asset('images/donald_trump.webp')}}" alt="">
                        Donald Trump
                    </div>
                </td>
                <td>4 Shirley Ave. West Chicago, IL 60185</td>
                <td>May 18, 2021</td>
                <td>May 18, 2021</td>
                <td><div class="progress-bar"><div class="progress red"></div></div></td>
                <td><button class="status-btn admit">Admit</button></td>
            </tr>
            <tr>
                <td>
                    <div class="patient-info">
                        <img src="{{asset('images/sheikh_hasina.webp')}}" alt="">
                        Sheikh Hasina
                    </div>
                </td>
                <td>123 6th St. Melbourne, FL 32904</td>
                <td>May 13, 2021</td>
                <td>May 22, 2021</td>
                <td><div class="progress-bar"><div class="progress green"></div></div></td>
                <td><button class="status-btn discharge">Discharge</button></td>
            </tr>
            <!-- Add remaining rows similarly -->
        </tbody>
    </table>

    <div class="table-footer">
        <div>Showing 1 to 10 of 10 entries</div>
        <div class="pagination">
            <button>Previous</button>
            <button class="active">1</button>
            <button>Next</button>
        </div>
    </div>
</div>
@endsection