function postToDelete(idPost) {
    let isExecuted = confirm("Are you sure you want to delete this post?");
    if (isExecuted) {
        var requestOptions = {
            method: 'DELETE',
            redirect: 'follow'
        };

        fetch(`http://localhost/Facebouk/postProcessors/postsApi.php?idPost=${idPost}`, requestOptions)
            .then(response => response.text())
            .then(result => {
                location.reload();
            })
            .catch(error => console.log('error', error));
    }
}