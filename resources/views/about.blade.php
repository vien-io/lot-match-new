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
                <strong>LotMatch</strong> is a web-based real estate analytics platform designed to visualize subdivision data in 
                <strong>3D</strong>, collect <strong>user reviews</strong>, and generate <strong>AI-powered insights</strong> such as sentiment analysis 
                and forecasted property ratings. It unifies interactive visualization, data analytics, and AI processing 
                into a seamless environment for researchers, property developers, and managers.
            </p>
            <ul class="tw-list-disc tw-pl-6 tw-text-gray-700 tw-mt-2">
                <li>3D property visualization using Three.js</li>
                <li>AI-driven sentiment analysis on user reviews</li>
                <li>Exponential Moving Average (EMA) forecasting for property ratings</li>
                <li>Dynamic charts and summaries via Chart.js</li>
                <li>Responsive TailwindCSS interface with Laravel Blade templates</li>
                <li>Asynchronous background processing through Laravel Jobs</li>
            </ul>
        </section>

        <!-- 3D Visualization & Interaction -->
        <section class="tw-mb-6">
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">3D Visualization & Interaction</h2>
            <p class="tw-text-gray-700">
                The platform leverages <strong>Three.js</strong> to render interactive 3D scenes of blocks and individual lots. 
                Users can pan, zoom, and rotate the camera with intuitive controls. Each property is represented as a 
                Level-of-Detail (LOD) 3D model to ensure smooth performance even for large subdivisions.
                Hovering over houses or blocks highlights them, displays tooltips, and allows selection for detailed views.
                Modal popups provide detailed 3D previews, AI summaries, user reviews, and forecast data.
            </p>
            <p class="tw-text-gray-700 tw-mt-2">
                Interactive features include real-time highlighting via <strong>raycasting</strong>, 
                dynamic modal loading for lot/block details, AI forecast overlays, and responsive chart rendering.
            </p>
        </section>

        <!-- Data Flow -->
        <section class="tw-mb-6">
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">Data Flow</h2>
            <p class="tw-text-gray-700">
                The system processes and visualizes data through several coordinated steps:
            </p>
            <ul class="tw-list-disc tw-pl-6 tw-text-gray-700">
                <li>Users submit reviews and ratings through interactive 3D map modals.</li>
                <li><strong>ReviewController</strong> handles creation, updating, and deletion of reviews.</li>
                <li><strong>AnalyzeSentimentJob</strong> classifies user comments using NLP models from Hugging Face.</li>
                <li><strong>GenerateBlockSummaryJob</strong> aggregates reviews and generates AI-based natural language summaries.</li>
                <li><strong>ForecastController</strong> computes Exponential Moving Average (EMA) scores and produces trend charts.</li>
                <li>The front-end dynamically updates 3D modals, summaries, and forecast charts in real time.</li>
            </ul>
        </section>

        <!-- Algorithms & Processing -->
        <section class="tw-mb-6">
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">Algorithms & Processing</h2>
            <ul class="tw-list-disc tw-pl-6 tw-text-gray-700">
                <li><strong>Exponential Moving Average (EMA):</strong> Smooths historical ratings to forecast block performance trends.</li>
                <li><strong>Sentiment Analysis:</strong> NLP models classify user reviews as positive, neutral, or negative.</li>
                <li><strong>Data Aggregation:</strong> Background jobs consolidate ratings and sentiments into AI-generated summaries.</li>
                <li><strong>Forecast Visualization:</strong> Chart.js displays historical and forecasted scores, highlighting predicted trends.</li>
                <li><strong>3D Interaction Logic:</strong> Raycasting detects hover/click events on properties to trigger visual feedback and modals.</li>
            </ul>
        </section>

        <!-- System Architecture -->
        <section class="tw-mb-6">
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">System Architecture</h2>
            <p class="tw-text-gray-700">
                Built on the <strong>Laravel</strong> framework, the system follows an MVC structure and modular design. 
                Eloquent models manage data persistence, while Blade templates and TailwindCSS power the responsive interface. 
                Asynchronous Jobs handle intensive operations like AI sentiment analysis and forecast calculations, 
                maintaining a responsive user experience.
            </p>
            <p class="tw-text-gray-700 tw-mt-2">Core backend components include:</p>
            <ul class="tw-list-disc tw-pl-6 tw-text-gray-700">
                <li><strong>Controllers:</strong> ReviewController, ForecastController</li>
                <li><strong>Jobs:</strong> AnalyzeSentimentJob, GenerateBlockSummaryJob</li>
                <li><strong>Models:</strong> User, Block, Review, Forecast, Summary</li>
            </ul>
            <p class="tw-text-gray-700 tw-mt-2">Database tables include:</p>
            <ul class="tw-list-disc tw-pl-6 tw-text-gray-700">
                <li><strong>users:</strong> Registered users and administrators.</li>
                <li><strong>blocks:</strong> Subdivision blocks under management.</li>
                <li><strong>reviews:</strong> User-submitted ratings and comments per block or lot.</li>
                <li><strong>forecasts & summaries:</strong> AI-generated summaries and projected block ratings.</li>
            </ul>
        </section>

        <!-- Example Workflow -->
        <section class="tw-mb-6">
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">Example Review & Forecast Workflow</h2>
            <ul class="tw-list-disc tw-pl-6 tw-text-gray-700">
                <li>The user submits a review with a star rating and optional comment.</li>
                <li><strong>ReviewController</strong> stores the review and dispatches background jobs for analysis.</li>
                <li><strong>AnalyzeSentimentJob</strong> evaluates the review using AI sentiment models.</li>
                <li><strong>GenerateBlockSummaryJob</strong> updates the block summary with aggregated data.</li>
                <li><strong>ForecastController</strong> calculates the EMA forecast and integrates it into trend charts.</li>
                <li>The front-end updates in real time with new reviews, summaries, and forecasted trends displayed in 3D modals and analytics charts.</li>
            </ul>
        </section>

        <!-- Design & User Experience -->
        <section class="tw-mb-6">
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">Design & User Experience</h2>
            <p class="tw-text-gray-700">
                The system emphasizes clarity, performance, and immersion. Real-time AI processing ensures feedback loops 
                between user actions and visual updates. TailwindCSS gradients, shadows, and rounded corners create 
                a clean, modern dashboard aesthetic.
            </p>
            <ul class="tw-list-disc tw-pl-6 tw-text-gray-700 tw-mt-2">
                <li><strong>Immersive Visualization:</strong> 3D interaction replaces static property lists.</li>
                <li><strong>AI Feedback Loop:</strong> User reviews immediately influence analytics and forecasts.</li>
                <li><strong>Scalable Rendering:</strong> Instanced 3D meshes maintain smooth performance on large maps.</li>
                <li><strong>Responsive Design:</strong> TailwindCSS ensures seamless layout on all devices.</li>
            </ul>
        </section>

        <!-- Summary -->
        <section>
            <h2 class="tw-text-2xl tw-font-semibold tw-mb-2">Summary</h2>
            <p class="tw-text-gray-700">
                By integrating <strong>3D visualization</strong>, <strong>AI sentiment analysis</strong>, 
                and <strong>forecasting analytics</strong>, LotMatch provides an advanced and responsive system 
                for real estate performance monitoring. It delivers actionable insights through immersive visualization, 
                intelligent automation, and scalable architecture—transforming static property data into 
                a living, interactive, and data-driven experience.
            </p>
        </section>

    </div>
</div>
@endsection
