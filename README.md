# LotMatch – 3D Real Estate Analytics Platform

LotMatch is a web-based real estate analytics and visualization system that combines immersive 3D exploration, AI-powered sentiment analysis, and forecasted property ratings. Designed for property developers, researchers, and administrators, it transforms raw subdivision data into actionable insights through interactive visualization, predictive analytics, and real-time AI feedback.

--------------------------------------------------------------------

## Key Features

* 3D Property Visualization – Explore lots and blocks with full interactivity using Three.js.
* User Reviews & AI Sentiment Analysis – NLP models classify user comments as positive, neutral, or negative.
* EMA-based Rating Forecasting – Smooth historical ratings to predict block performance trends.
* AI-Generated Block Summaries – Dynamic summaries of user feedback for each subdivision block.
* Dynamic Charts & Analytics – Trend lines and rating distributions rendered with Chart.js.
* Laravel + TailwindCSS Full-Stack Architecture – Responsive UI with modular MVC design.
* Asynchronous Background Jobs – Ensures smooth performance while processing AI sentiment and forecasts.
* Real-Time Updates – Reviews trigger live updates to charts, summaries, and 3D modals.

--------------------------------------------------------------------

## System Architecture

LotMatch follows a modular MVC architecture enhanced with micro-interactions and background processing.

### Backend (Laravel)

**Controllers**

* `ReviewController` – Review CRUD operations
* `ForecastController` – EMA forecasting and analytics

**Jobs / Workers**

* `AnalyzeSentimentJob` – NLP-based sentiment classification
* `GenerateBlockSummaryJob` – AI-generated summaries per block

**Models**

* `User`, `Block`, `Review`, `Forecast`, `Summary`

**Database Tables**

* `users`
* `blocks`
* `reviews`
* `forecasts`
* `summaries`

### Frontend

* Laravel Blade for server-rendered views
* TailwindCSS for responsive, modern UI
* Three.js for 3D visualization engine
* Chart.js for data and forecast charts
* Vite for modular JavaScript bundling

--------------------------------------------------------------------

## Data Flow Overview

1. User submits a review via the UI
2. `ReviewController` stores the review
3. `AnalyzeSentimentJob` evaluates sentiment
4. `GenerateBlockSummaryJob` updates AI summary
5. `ForecastController` recalculates EMA forecasts
6. Frontend dynamically refreshes charts, summaries, and 3D modals

--------------------------------------------------------------------

## Algorithms Used

1. Exponential Moving Average (EMA) – Smooths historical ratings to forecast trends.
2. Sentiment Analysis – Classifies reviews as positive, neutral, or negative using NLP models.
3. Data Aggregation – Consolidates ratings and sentiments into AI-generated block summaries.
4. Predictive Visualization – Chart.js displays historical and forecasted trends.
5. 3D Interaction Logic – Raycasting detects hover/click events to trigger modals and highlight lots/blocks.

--------------------------------------------------------------------

## Dashboard Module (`dashboard.blade.php`)

The dashboard serves as the system’s central analytics hub.

**Includes:**

* Personalized welcome section
* Statistic cards (blocks, lots, ratings, reviews)
* Lightweight 3D subdivision preview
* Rating distribution charts
* Recent reviews panel

--------------------------------------------------------------------

## 3D Map Interface (`3dmap.blade.php`)

This page hosts the core interactive experience of LotMatch.

**Features:**

* Full-screen 3D navigation (pan, zoom, rotate)
* Lot modal with attributes, images, and risk data
* Block modal with reviews, summaries, and forecasts
* Full forecast report modal
* AI status indicators and tooltips

--------------------------------------------------------------------

## 3D Visualization Engine (`3dmap.js`)

Handles the full Three.js environment:

* Scene, camera, renderer, controls, and lighting
* InstancedMesh for high-performance lot rendering
* Raycasting for hover and click detection
* Post-processing with EffectComposer (Outline + FXAA)

**Rendering Loop:**

```js
requestAnimationFrame(animate);
controls.update();
composer.render();
```

--------------------------------------------------------------------

## Modular Three.js Components

| Module         | Responsibility                      |
| -------------- | ----------------------------------- |
| `initScene`    | Base scene creation                 |
| `initRenderer` | WebGL renderer setup                |
| `initCamera`   | Perspective camera (40° FOV)        |
| `initControls` | OrbitControls with damping          |
| `initLights`   | Ambient & directional lights        |
| `initSky`      | Sky dome and lighting               |
| `loadHouses`   | Loads models and InstancedMesh lots |

--------------------------------------------------------------------

## AI and Analytics Modules

### Forecasting (`forecastHandler.js`)

* Fetches `/forecast/block/:id`
* Renders historical and predicted EMA ratings
* Highlights forecast points

### Reviews (`reviewHandler.js`)

* Handles review CRUD via AJAX
* Triggers AI jobs on submission
* Polls backend for forecast completion
* Refreshes summaries and charts dynamically

--------------------------------------------------------------------

## Example Workflow

**Submitting a Review:**

1. User posts a rating and comment
2. Backend stores the review
3. AI analyzes sentiment
4. Block summary is regenerated
5. EMA forecast is recalculated
6. UI updates charts, summaries, and 3D views

--------------------------------------------------------------------

## Demo Accounts

LotMatch comes with pre-seeded users for testing:

| Username | Role  | Email                  | Password    |
|----------|-------|------------------------|-------------|
| admin    | admin | admin@example.com      | Password123 |
| buyer    | buyer | buyer@example.com      | Password123 |
| owner1   | owner | owner1@example.com     | Password123 |
| owner2   | owner | owner2@example.com     | Password123 |
| owner3   | owner | owner3@example.com     | Password123 |
| owner4   | owner | owner4@example.com     | Password123 |

Use these accounts to explore admin dashboards, review submissions, and 3D map features.

--------------------------------------------------------------------

## Design Philosophy

* Immersive Interaction – 3D replaces static tables
* Immediate Intelligence – Reviews trigger AI insights
* Scalable Performance – Instanced rendering
* Clean UI – Minimalist TailwindCSS design

--------------------------------------------------------------------

## Summary

LotMatch transforms traditional real estate data into a living, intelligent, and interactive visualization system by merging:

* AI-powered analytics
* Immersive 3D exploration
* Real-time forecasting dashboards

LotMatch turns raw property data into actionable insight.
