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

    perfilForm.addEventListener('submit', async function (e) {
        e.preventDefault();
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
});