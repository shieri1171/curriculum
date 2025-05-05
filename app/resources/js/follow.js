document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.follow-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id');
            const btn = this;

            fetch('/follow/' + userId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'followed') {
                    btn.classList.remove('btn-outline-secondary');
                    btn.classList.add('btn-info');
                    btn.textContent = 'フォロー解除';
                } else {
                    btn.classList.remove('btn-info');
                    btn.classList.add('btn-outline-secondary');
                    btn.textContent = 'フォロー';
                }
            })
            .catch(error => {
                console.error('エラー:', error);
            });
        });
    });
});