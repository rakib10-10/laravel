
@extends('admin.home')

@section('content')
<style>
    /* New modern color palette and typography */
    :root {
        --primary-color: #4A90E2;
        --secondary-color: #50E3C2;
        --text-dark: #333;
        --text-light: #666;
        --bg-light: #F8F9FA;
        --card-bg: #fff;
        --border-color: #e0e0e0;
        --shadow: rgba(0, 0, 0, 0.08);
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-light);
        color: var(--text-dark);
    }

    .medicines-page {
        padding: 40px;
    }

    .medicines-page h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 30px;
        color: var(--primary-color);
        border-bottom: 2px solid var(--secondary-color);
        padding-bottom: 10px;
    }

    /* Search and Filter Section */
    .search-filter {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        align-items: center;
    }

    .search-filter input,
    .search-filter select {
        padding: 12px 20px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        font-size: 1rem;
        color: var(--text-dark);
        background-color: var(--card-bg);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        flex: 1;
    }

    .search-filter input:focus,
    .search-filter select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }

    .search-filter select {
        flex: 0.5;
        cursor: pointer;
    }

    /* Medicine Grid Layout */
    .medicines-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
    }

    /* Individual Medicine Card */
    .medicine-card {
        background: var(--card-bg);
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 8px 25px var(--shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .medicine-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .medicine-card h3 {
        margin: 0 0 10px;
        font-size: 1.5rem;
        color: var(--primary-color);
        font-weight: 600;
    }

    .medicine-card p {
        margin: 8px 0;
        font-size: 0.95rem;
        color: var(--text-light);
        line-height: 1.5;
    }

    .medicine-card p strong {
        color: var(--text-dark);
    }

    .details-btn {
        background: var(--primary-color);
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        transition: background 0.3s ease, transform 0.2s ease;
        margin-top: 20px;
        align-self: flex-start;
    }

    .details-btn:hover {
        background: #3a7ac8;
        transform: scale(1.02);
    }

</style>

<div class="medicines-page">
    <h1>Medicines</h1>

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

    <div class="medicines-grid">
        {{-- Loop through the medicines collection --}}
        @foreach($medicines as $medicine)
            <div class="medicine-card">
                <div>
                    <h3>{{ $medicine->name }}</h3>
                    <p><strong>Dosage Form:</strong> {{ $medicine->dosage_form }}</p>
                    <p><strong>Strength:</strong> {{ $medicine->strength }}</p>
                    <p><strong>Manufacturer:</strong> {{ $medicine->manufacturer }}</p>
                    <p><strong>Description:</strong> {{ $medicine->description }}</p>
                </div>
                <button class="details-btn">View Details</button>
            </div>
        @endforeach
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
            let matchesSearch = name.includes(searchValue);
            let matchesCategory = categoryValue === "" || name.includes(categoryValue.toLowerCase());

            if (matchesSearch && matchesCategory) {
                card.style.display = "flex"; /* Changed from 'block' to 'flex' to maintain layout */
            } else {
                card.style.display = "none";
            }
        });
    }
</script>

@endsection