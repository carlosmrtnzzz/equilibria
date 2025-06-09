function validarFechaNacimiento() {
    const birthDate = document.getElementById('birth_date');
    const errorBirthDate = document.getElementById('error_birth_date');
    let valid = true;

    if (!birthDate.value) {
        errorBirthDate.textContent = 'La fecha de nacimiento es obligatoria';
        errorBirthDate.classList.remove('hidden');
        birthDate.classList.add('border-red-500');
        valid = false;
    } else {
        const inputDate = new Date(birthDate.value);
        const year = birthDate.value.split('-')[0];
        const today = new Date();
        const minDate = new Date(today.getFullYear() - 100, today.getMonth(), today.getDate());
        if (year.length > 4) {
            errorBirthDate.textContent = 'El año debe tener máximo 4 dígitos';
            errorBirthDate.classList.remove('hidden');
            birthDate.classList.add('border-red-500');
            valid = false;
        } else if (inputDate > today) {
            errorBirthDate.textContent = 'La fecha no puede ser en el futuro';
            errorBirthDate.classList.remove('hidden');
            birthDate.classList.add('border-red-500');
            valid = false;
        } else if (inputDate < minDate) {
            errorBirthDate.textContent = 'La fecha no puede ser anterior a hace 100 años';
            errorBirthDate.classList.remove('hidden');
            birthDate.classList.add('border-red-500');
            valid = false;
        } else {
            errorBirthDate.classList.add('hidden');
            birthDate.classList.remove('border-red-500');
        }
    }
    return valid;
}

function validarSexo() {
    const genderMale = document.getElementById('gender_male');
    const genderFemale = document.getElementById('gender_female');
    const errorGender = document.getElementById('error_gender');
    let valid = true;
    if (!genderMale.checked && !genderFemale.checked) {
        errorGender.textContent = 'Selecciona un sexo';
        errorGender.classList.remove('hidden');
        valid = false;
    } else {
        errorGender.classList.add('hidden');
    }
    return valid;
}

function validarPeso() {
    const weight = document.getElementById('weight');
    const errorWeight = document.getElementById('error_weight');
    let valid = true;
    if (!weight.value || weight.value < 1 || weight.value > 500) {
        errorWeight.textContent = 'Introduce un peso válido (1-500 kg)';
        errorWeight.classList.remove('hidden');
        weight.classList.add('border-red-500');
        valid = false;
    } else {
        errorWeight.classList.add('hidden');
        weight.classList.remove('border-red-500');
    }
    return valid;
}

function validarAltura() {
    const height = document.getElementById('height');
    const errorHeight = document.getElementById('error_height');
    let valid = true;
    if (!height.value || height.value < 30 || height.value > 300) {
        errorHeight.textContent = 'Introduce una altura válida (30-300 cm)';
        errorHeight.classList.remove('hidden');
        height.classList.add('border-red-500');
        valid = false;
    } else {
        errorHeight.classList.add('hidden');
        height.classList.remove('border-red-500');
    }
    return valid;
}

document.getElementById('birth_date').addEventListener('input', validarFechaNacimiento);
document.getElementById('weight').addEventListener('input', validarPeso);
document.getElementById('height').addEventListener('input', validarAltura);
document.getElementById('gender_male').addEventListener('change', validarSexo);
document.getElementById('gender_female').addEventListener('change', validarSexo);

document.getElementById('userForm').addEventListener('submit', function (e) {
    let valid = true;
    if (!validarFechaNacimiento()) valid = false;
    if (!validarSexo()) valid = false;
    if (!validarPeso()) valid = false;
    if (!validarAltura()) valid = false;
    if (!valid) e.preventDefault();
});