@props(['image', 'title', 'description'])

<style>
    .custom-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(255, 126, 95, 0.15);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .custom-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 20px 48px rgba(255, 126, 95, 0.25);
    }

    .custom-card-img-wrapper {
        overflow: hidden;
        position: relative;
        aspect-ratio: 3/4;
    }

    .custom-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .custom-card:hover img {
        transform: scale(1.12) rotate(2deg);
    }

    .custom-card-img-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(255, 126, 95, 0.3) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .custom-card:hover .custom-card-img-overlay {
        opacity: 1;
    }

    .custom-card-content {
        padding: 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        background: linear-gradient(to bottom, #ffffff 0%, #fff8f5 100%);
    }

    .custom-card h3 {
        color: #ff7e5f;
        margin-bottom: 14px;
        font-size: 1.4em;
        font-weight: 700;
        line-height: 1.3;
    }

    .custom-card p {
        color: #555;
        line-height: 1.8;
        flex-grow: 1;
        font-size: 0.95em;
    }

    .custom-card-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: rgba(255, 126, 95, 0.9);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
        backdrop-filter: blur(8px);
    }
</style>

<div class="custom-card">
    <div class="custom-card-img-wrapper">
        <img src="{{ asset('images/' . $image) }}" alt="{{ $title }}">
        <div class="custom-card-img-overlay"></div>
    </div>
    <div class="custom-card-content">
        <h3>{{ $title }}</h3>
        <p>{{ $description }}</p>
    </div>
</div>