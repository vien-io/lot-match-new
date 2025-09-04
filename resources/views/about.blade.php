{{-- resources/views/about.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="tw-min-h-screen tw-bg-gray-50 tw-p-8">
    <div class="tw-max-w-6xl tw-mx-auto tw-bg-white tw-rounded-2xl tw-shadow-lg tw-p-8">
        <h1 class="tw-text-3xl tw-font-bold tw-mb-6">Technical Documentation / System Overview</h1>

        <!-- System Overview -->
        <section class="tw-mb-6">
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">System Overview</h2>
            <p class="tw-text-gray-700">
                This platform is a comprehensive web-based system for real estate property management, 
                combining 3D property visualization, user reviews, and forecasted property ratings. 
                Users can submit ratings and detailed comments for individual lots or blocks, which are 
                analyzed using AI-based sentiment detection and statistical forecasting techniques. 
                The system provides administrators with actionable insights and intuitive 3D interfaces 
                to manage and monitor properties effectively.
            </p>
        </section>

        <!-- 3D Visualization & Interaction -->
        <section class="tw-mb-6">
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">3D Visualization & Interaction</h2>
            <p class="tw-text-gray-700">
                The front-end leverages Three.js to render interactive 3D scenes of blocks and individual lots. 
                Users can rotate, pan, and zoom the camera using intuitive controls. 
                Each property is represented as a Level-of-Detail (LOD) 3D model, ensuring smooth performance 
                even for complex scenes. Hovering over houses or blocks highlights them, displays tooltips, 
                and allows selection for detailed views. Additionally, modal popups provide detailed 3D previews 
                of properties and integrated review sections.
            </p>
        </section>

        <!-- Data Flow -->
        <section class="tw-mb-6">
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">Data Flow</h2>
            <p class="tw-text-gray-700">
                The system workflow involves several key steps:
            </p>
            <ul class="tw-list-disc tw-pl-6 tw-text-gray-700">
                <li>Users submit reviews through interactive front-end forms.</li>
                <li>ReviewController handles creation, update, and deletion of reviews.</li>
                <li>AnalyzeSentimentJob evaluates the sentiment of user comments using NLP models from Hugging Face.</li>
                <li>GenerateBlockSummaryJob aggregates reviews and produces AI-generated summaries for each block.</li>
                <li>ForecastController calculates Exponential Moving Average (EMA) ratings and generates trend reports for visualization in charts.</li>
            </ul>
        </section>

        <!-- Algorithms -->
        <section class="tw-mb-6">
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">Algorithms & Processing</h2>
            <ul class="tw-list-disc tw-pl-6 tw-text-gray-700">
                <li><strong>Exponential Moving Average (EMA):</strong> Smooths historical ratings to forecast block scores.</li>
                <li><strong>Sentiment Analysis:</strong> Uses NLP models to classify reviews as positive, negative, or neutral.</li>
                <li><strong>Data Aggregation:</strong> Chains background jobs to consolidate review data into block summaries and forecasts.</li>
                <li><strong>Forecast Visualization:</strong> Chart.js displays historical ratings along with forecasted points, highlighting predicted trends for administrators.</li>
                <li><strong>3D Interaction Logic:</strong> Raycasting detects mouse hover and clicks on houses or blocks, triggering highlights, tooltips, and modal popups.</li>
            </ul>
        </section>

        <!-- System Architecture -->
        <section class="tw-mb-6">
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">System Architecture</h2>
            <p class="tw-text-gray-700">
                Built on Laravel, the system uses Eloquent models (User, Block, Review) for data persistence. 
                Blade templates render the front-end with TailwindCSS for responsive styling. 
                Asynchronous Jobs handle compute-heavy tasks such as sentiment analysis, block summary generation, and EMA forecasting, 
                keeping the UI responsive and smooth.
            </p>
            <p class="tw-text-gray-700 tw-mt-2">
                Database tables include:
            </p>
            <ul class="tw-list-disc tw-pl-6 tw-text-gray-700">
                <li><strong>users:</strong> Registered users and administrators.</li>
                <li><strong>blocks:</strong> Properties or blocks under management.</li>
                <li><strong>reviews:</strong> User-submitted ratings and comments for blocks or lots.</li>
                <li><strong>forecasts & summaries:</strong> AI-generated summaries and predicted ratings per block.</li>
            </ul>
        </section>

        <!-- Example Workflow -->
        <section class="tw-mb-6">
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">Example Review & Forecast Workflow</h2>
            <ul class="tw-list-disc tw-pl-6 tw-text-gray-700">
                <li>User submits a review with a star rating and optional comment.</li>
                <li>ReviewController stores the review and triggers background jobs for sentiment analysis.</li>
                <li>AnalyzeSentimentJob classifies the comment sentiment and stores the result.</li>
                <li>GenerateBlockSummaryJob consolidates all reviews to produce a natural-language summary for the block.</li>
                <li>ForecastController calculates the EMA forecast and combines it with sentiment trends for chart visualization.</li>
                <li>The front-end updates dynamically to reflect new reviews, summaries, and forecast trends in 3D modals and charts.</li>
            </ul>
        </section>

        <!-- Summary -->
        <section>
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">Summary</h2>
            <p class="tw-text-gray-700">
                By integrating real-time 3D visualization, AI-based sentiment analysis, EMA forecasting, 
                and responsive frontend interactions, this system provides administrators and users with 
                a comprehensive view of property performance. It combines actionable insights, interactive graphics, 
                and scalable backend processing to ensure a user-friendly, high-performance experience.
            </p>
        </section>
    </div>
</div>
@endsection
