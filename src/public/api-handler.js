import sendFormData from "./formSender.js";

let convertButton = document.getElementById('convert-button');
let inputForm = document.getElementById('form');
let outputDiv = document.getElementById('result-element');
let currencyInput = document.getElementById('outputCurrency');
let suggestionDropdown = document.getElementById('currency-suggestions');
const url = '/api.php';

const debounce = (callback, wait) => {
    let timeoutId = null;
    return (...args) => {
      window.clearTimeout(timeoutId);
      timeoutId = window.setTimeout(() => {
        callback.apply(null, args);
      }, wait);
    };
}

async function convert(button, form, outputDiv)
{
    let data = collectData(form);
    toggleSpinner(button, false);
    toggleSpinner(outputDiv, false);
    let response = await sendFormData(data, 'convert', url);
    if(checkErrors(response)){
        fillResult(outputDiv, response);
    } else {
        alert(response.message);
    }
    toggleSpinner(button, true);
    toggleSpinner(outputDiv, true);

    console.log(data);
    console.log(response);
    
}

function generateListItem(details, target, dropdownElement){
    let generatedItem = document.createElement('li');
    let a = document.createElement('a');
    generatedItem.append(a);
    a.classList.add('dropdown-item');
    a.innerText = details.code + ' - ' + details.description;
    a.href = '#';
    a.addEventListener('click', () => {
        target.value = details.code;
        dropdownElement.classList.remove('show');
    });
    return generatedItem;
}

// get input, autofinish show 3 entries to click on from api
async function fetchCurrency(input, dropdown){
    let value = input.value.toUpperCase();
    dropdown.innerText = '';
    dropdown.classList.remove('show');
    if(!value){
        return;
    }
    let response = await sendFormData({'query': value}, 'getCurrencies', url);
    if(checkErrors(response)){
        // console.log(response.result.currencies);
        if(response.result.currencies.length === 0){
            return;
        }
        for(const [key, value] of Object.entries(response.result.currencies)){
            dropdown.append(generateListItem(value,input,dropdown));
        }
        dropdown.classList.add('show');
    }
}



function checkErrors(response){
    // do error handling too
    return response.status === 'success';
}

function collectData(form){
    let data = {};
    let inputs = [...form.querySelectorAll('input, select')];

    inputs.forEach(element => {
        data[String(element.id)] = element.value; 
    });

    return data;
}

function fillResult(resultContainer, data){
    let target = resultContainer.querySelector('h1');
    target.innerText = String(parseFloat(data.query.inputAmount).toFixed(2)) + ' ' + data.query.inputCurrency 
    + ' ≈ ' + String(data.result.outputAmount.toFixed(6)) + ' ' + data.query.outputCurrency;
}



function toggleSpinner(element, force = null){
    let spinner = element.querySelector('.spinner-grow, .spinner-border');
    let span = element.querySelector('.inner-span');
    if(force === true || (force == null && element.disabled === false)){
        element.disabled = false;
        spinner.classList.add('visually-hidden');
        span.classList.remove('visually-hidden');
        return true;
    } else {
        element.disabled = true;
        spinner.classList.remove('visually-hidden');
        span.classList.add('visually-hidden');
        return false;
    }
}


convertButton.addEventListener('click', () =>{
    convert(convertButton, inputForm, outputDiv);
});


currencyInput.addEventListener('input', debounce(()=>{
    fetchCurrency(currencyInput, suggestionDropdown);
}, 500));