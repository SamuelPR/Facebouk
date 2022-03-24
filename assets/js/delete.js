function postToDelete(idPost) {
    let isExecuted = confirm("Are you sure you want to delete this post?");
    console.log(isExecuted);
    if (isExecuted) {
        var requestOptions = {
            method: 'GET',
            redirect: 'follow'
        };

        fetch(`http://localhost/Facebouk/assets/postsApi.php?idPost=${idPost}`, requestOptions)
            .then(response => response.text())
            .then(result => {
                //TODO Change to alert
                console.log(result);
            })
            .catch(error => console.log('error', error));
    }
}