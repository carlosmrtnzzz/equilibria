document.addEventListener('DOMContentLoaded', function () {
    const perfilForm = document.getElementById('perfil-form');
    if (!perfilForm) return;

    function toTitleCase(str) {
        return str
            .toLowerCase()
            .split(' ')
            .filter(Boolean)
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    }

    const fields = [
        { id: 'name', validate: v => v.trim() !== '', message: 'El nombre es obligatorio.' },
        { id: 'age', validate: v => v.trim() !== '' && Number(v) > 0 && Number(v) <= 120, message: 'Edad no válida.' },
        { id: 'weight_kg', validate: v => v.trim() !== '' && Number(v) > 0 && Number(v) <= 500, message: 'Peso no válido.' },
        { id: 'height_cm', validate: v => v.trim() !== '' && Number(v) > 0 && Number(v) <= 300, message: 'Altura no válida.' }
    ];

    perfilForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        let hasError = false;
        fields.forEach(field => {
            const input = document.getElementById(field.id);
            const errorMsg = document.getElementById(`${field.id}-error`);
            if (input && errorMsg) {
                if (!field.validate(input.value)) {
                    input.classList.add('border-red-400');
                    errorMsg.textContent = field.message;
                    errorMsg.classList.remove('hidden');
                    hasError = true;
                } else {
                    input.classList.remove('border-red-400');
                    errorMsg.textContent = '';
                    errorMsg.classList.add('hidden');
                }
            }
        });
        if (hasError) return; // No envía si hay errores

        const nameInput = perfilForm.querySelector('input[name="name"]');
        if (nameInput && nameInput.value.length > 0) {
            nameInput.value = toTitleCase(nameInput.value);
        }

        const form = e.target;
        const data = new FormData(form);

        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: data
        });

        if (response.ok) {
            const result = await response.json();
            document.querySelectorAll('.nombre-usuario').forEach(el => el.textContent = result.name.charAt(0).toUpperCase() + result.name.slice(1));
            document.querySelectorAll('.edad-usuario').forEach(el => el.textContent = result.age + ' años');
            let generoTexto = 'No especificado';
            if (result.gender === 'male') {
                generoTexto = 'Hombre';
            } else if (result.gender === 'female') {
                generoTexto = 'Mujer';
            }
            document.querySelectorAll('.genero-usuario').forEach(el => el.textContent = generoTexto);
            document.querySelectorAll('.peso-usuario').forEach(el => el.textContent = result.weight_kg + ' kg');
            document.querySelectorAll('.altura-usuario').forEach(el => el.textContent = result.height_cm + ' cm');

            // Recalcula y actualiza el IMC y sus estilos
            const peso = parseFloat(result.weight_kg);
            const altura = parseFloat(result.height_cm) / 100;
            let imc = null, categoria = '', color = '', iconColor = '', textColor = '';
            if (peso && altura) {
                imc = (peso / (altura * altura)).toFixed(1);
                if (imc < 18.5) {
                    categoria = 'Bajo peso';
                    color = 'from-blue-50 to-indigo-50 border-blue-200/50';
                    iconColor = 'from-blue-500 to-indigo-500';
                    textColor = 'text-blue-700';
                } else if (imc < 25) {
                    categoria = 'Normal';
                    color = 'from-green-50 to-emerald-50 border-green-200/50';
                    iconColor = 'from-green-500 to-emerald-500';
                    textColor = 'text-green-700';
                } else if (imc < 30) {
                    categoria = 'Sobrepeso';
                    color = 'from-yellow-50 to-orange-50 border-yellow-200/50';
                    iconColor = 'from-yellow-500 to-orange-500';
                    textColor = 'text-yellow-700';
                } else {
                    categoria = 'Obesidad';
                    color = 'from-red-50 to-pink-50 border-red-200/50';
                    iconColor = 'from-red-500 to-pink-500';
                    textColor = 'text-red-700';
                }
            }

            // Actualiza el valor y color del IMC
            document.querySelectorAll('.imc-valor').forEach(el => {
                if (imc) {
                    el.textContent = `${imc} - ${categoria}`;
                    el.className = `imc-valor ${textColor} font-medium`;
                } else {
                    el.textContent = '';
                    el.className = 'imc-valor';
                }
            });

            // Actualiza el color del título IMC
            document.querySelectorAll('.imc-titulo').forEach(el => {
                el.className = `imc-titulo font-semibold ${textColor}`;
            });

            // Actualiza la caja y el icono del IMC
            const imcBox = document.getElementById('imc-box');
            if (imcBox) {
                imcBox.className = `imc-usuario bg-gradient-to-r ${color} rounded-2xl p-6 border transform hover:scale-105 transition-all duration-300`;
            }
            const imcIcon = document.getElementById('imc-icon');
            if (imcIcon) {
                imcIcon.className = `w-10 h-10 bg-gradient-to-r ${iconColor} rounded-xl flex items-center justify-center`;
            }

            document.getElementById('edit-modal').classList.add('hidden');
            mostrarToast('Perfil actualizado correctamente', 'success');
            
        } else {
            mostrarToast('Error al actualizar el perfil', 'error');
        }
    });

    const photoForm = document.getElementById('photo-form');
    const photoInput = document.getElementById('profile_photo');
    if (photoForm && photoInput) {
        const avatarImg = photoForm.querySelector('img');
        photoInput.addEventListener('change', function () {
            if (!photoInput.files.length) return;

            const file = photoInput.files[0];
            if (file.size > 1024 * 1024) { // 1MB
                mostrarToast("La foto debe ser de máximo 1MB", "error");
                photoInput.value = "";
                return;
            }

            let formData = new FormData();
            formData.append('profile_photo', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'PUT');

            fetch(photoForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                if (!response.ok) {
                    let data = await response.json().catch(() => ({}));
                    let msg = data.errors && data.errors.profile_photo ? data.errors.profile_photo[0] : "Error al subir la foto";
                    mostrarToast(msg, "error");
                    photoInput.value = "";
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data && data.profile_photo) {
                    avatarImg.src = '/storage/' + data.profile_photo + '?t=' + Date.now();
                    mostrarToast("Foto de perfil actualizada", "success");
                }
            })
            .catch(() => {
                mostrarToast("Error al subir la foto", "error");
                photoInput.value = "";
            });
        });
    }

    fields.forEach(field => {
        const input = document.getElementById(field.id);
        if (!input) return;

        // Crea el mensaje de error si no existe
        let errorMsg = document.getElementById(`${field.id}-error`);
        if (!errorMsg) {
            errorMsg = document.createElement('div');
            errorMsg.className = 'text-red-500 text-xs mt-1 hidden';
            errorMsg.id = `${field.id}-error`;
            input.parentNode.appendChild(errorMsg);
        }

        // Validación en tiempo real para quitar error si el usuario corrige
        input.addEventListener('input', () => {
            setTimeout(() => {
                if (field.validate(input.value)) {
                    input.classList.remove('border-red-400');
                    errorMsg.textContent = '';
                    errorMsg.classList.add('hidden');
                }
            }, 100);
        });
    });
});