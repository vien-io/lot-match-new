<script>
    window.App = {
        userId: {{ Illuminate\Support\Js::from(Auth::id()) }}
    };
</script>