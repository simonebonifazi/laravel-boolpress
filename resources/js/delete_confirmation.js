const deleteForms = document.querySelectorAll('.delete-form');
deleteForms.forEach( form => {
    form.addEventListener('submit', event => {
        event.preventDefault();
        const hasConfirmed = confirm('Sicuro di volerlo eliminare?');
        if(hasConfirmed) form.submit();
    });
});