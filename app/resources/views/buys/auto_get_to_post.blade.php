<form id="postForm" method="POST" action="{{ route('buy.conf') }}">
    @csrf
</form>

<script>
    document.getElementById('postForm').submit(); //自動送信
</script>