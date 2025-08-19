@extends('admin.home')
@section('medicines')
<style>
    .medicines-page {
    padding: 20px;
    font-family: 'Segoe UI', sans-serif;
    color: #2c3e50;
}

.medicines-page h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: #1d3557;
}

/* Search and Filter */
.search-filter {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.search-filter input,
.search-filter select {
    padding: 10px 15px;
    border-radius: 8px;
    border: 1px solid #dcdcdc;
    font-size: 1rem;
    flex: 1;
}

.search-filter select {
    flex: 0.4;
}

/* Medicine Grid */
.medicines-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

/* Medicine Card */
.medicine-card {
    background: #ffffff;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.medicine-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.12);
}

.medicine-card h3 {
    margin-top: 0;
    font-size: 1.2rem;
    color: #0077b6;
}

.medicine-card p {
    margin: 5px 0;
    font-size: 0.95rem;
    color: #555;
}

.details-btn {
    background: #0077b6;
    color: #fff;
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: background 0.2s ease;
}

.details-btn:hover {
    background: #023e8a;
}

</style>

<div class="medicines-page">
    <h1>Medicines</h1>

    <!-- Search & Filter -->
    <div class="search-filter">
        <input type="text" id="searchInput" placeholder="Search medicines...">
        <select id="categorySelect">
            <option value="">All Categories</option>
            <option value="Antibiotic">Antibiotic</option>
            <option value="Painkiller">Painkiller</option>
            <option value="Vitamins">Vitamins</option>
            <option value="Antiseptic">Antiseptic</option>
        </select>
    </div>

    <!-- Medicine Cards -->
    <div class="medicines-grid">
        <div class="medicine-card">
            <h3>Paracetamol</h3>
            <p><strong>Category:</strong> Painkiller</p>
            <p><strong>Stock:</strong> 150</p>
            <p><strong>Expiry:</strong> Dec 2025</p>
            <button class="details-btn">View Details</button>
        </div>

        <div class="medicine-card">
            <h3>Amoxicillin</h3>
            <p><strong>Category:</strong> Antibiotic</p>
            <p><strong>Stock:</strong> 80</p>
            <p><strong>Expiry:</strong> Aug 2024</p>
            <button class="details-btn">View Details</button>
        </div>

        <div class="medicine-card">
            <h3>Vitamin C</h3>
            <p><strong>Category:</strong> Vitamins</p>
            <p><strong>Stock:</strong> 200</p>
            <p><strong>Expiry:</strong> Jan 2026</p>
            <button class="details-btn">View Details</button>
        </div>
    </div>
</div>
<script>
    document.getElementById("searchInput").addEventListener("input", filterMedicines);
document.getElementById("categorySelect").addEventListener("change", filterMedicines);

function filterMedicines() {
    let searchValue = document.getElementById("searchInput").value.toLowerCase();
    let categoryValue = document.getElementById("categorySelect").value;
    let cards = document.querySelectorAll(".medicine-card");

    cards.forEach(card => {
        let name = card.querySelector("h3").innerText.toLowerCase();
        let category = card.querySelector("p").innerText.split(":")[1].trim();

        let matchesSearch = name.includes(searchValue);
        let matchesCategory = categoryValue === "" || category === categoryValue;

        if (matchesSearch && matchesCategory) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}

</script>

    
@endsection