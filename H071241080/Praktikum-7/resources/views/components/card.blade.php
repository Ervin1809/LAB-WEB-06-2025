<style>
    .card {
        background-color: white;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #E8DCC8;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(74, 93, 74, 0.12);
    }

    .card-image {
        width: 100%;
        height: 280px;
        overflow: hidden;
        background-color: #E8DCC8;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .card:hover .card-image img {
        transform: scale(1.05);
    }

    .card-content {
        padding: 1.75rem;
    }

    .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: #2C2C2C;
        margin-bottom: 0.75rem;
        letter-spacing: -0.3px;
    }

    .card-description {
        font-size: 0.9375rem;
        color: #666666;
        line-height: 1.7;
        font-weight: 300;
    }
    </style>

    <div class="card">
        @if(isset($image))
            <div class="card-image">
                <img src="{{ $image }}" alt="{{ $title }}">
            </div>
        @endif
        
        <div class="card-content">
            <h3 class="card-title">{{ $title }}</h3>
            <p class="card-description">{{ $description }}</p>
        </div>
    </div>
