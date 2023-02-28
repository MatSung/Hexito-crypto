export default async function sendFormData(data, type, url){
    const formData = new FormData();
    formData.append('type', type);
    Object.keys(data).forEach(entry => {
        formData.append(entry, data[entry]);
    });
    let response = await fetch(url, {
        method: 'POST',
        cache: 'no-cache',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
        .then(response => response.json());

    return response;
}