<div class="bg-white border-b border-gray-200 dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
    <div class="px-6 py-8 lg:py-12">
        <div class="container mx-auto">
            <form id="ServiceCancelForm" name="ServiceCancelForm" class="row g-3"
                action="{{ url('update_default_password') }}" method="POST" enctype="multipart/form-data">

                @csrf
                <div class="fr-grid-row">
                    <div class="mt-6 col-md-12">
                        <label for="newPass" class="block font-medium text-gray-700">Ingrese su nueva
                            contraseña:</label>
                        <input type="password" class="form-control mt-2 mb-2" required id="newPass" name="newPass"
                            onkeyup="validatePassword()">
                        <label for="newPass" class="block font-medium text-gray-700">Porfavor valide la
                            contraseña:</label>
                        <input type="password" class="form-control mt-2" required id="confirmPass" name="confirmPass"
                            onkeyup="confirmpass()">

                        <div id="passwordRequirements" style="display: none;">
                            <ul style="list-style-type: none; padding-left: 0;">
                                <li id="lengthRequirement" style="color: red; font-size: smaller;">&#x2190; Debe tener
                                    al menos 8 caracteres</li>
                                <li id="uppercaseRequirement" style="color: red; font-size: smaller;">&#x2190; Debe
                                    tener al menos una mayúscula</li>
                                <li id="numberRequirement" style="color: red; font-size: smaller;">&#x2190; Debe tener
                                    al menos un número</li>
                                <li id="specialCharRequirement" style="color: red; font-size: smaller;">&#x2190; Debe
                                    tener al menos un carácter especial</li>
                            </ul>
                        </div>
                        <div id="passwordConfirm" style="display: none;">
                            <ul style="list-style-type: none; padding-left: 0;">
                                <li id="matchRequirement" style="color: red; font-size: smaller;">&#x2190; Las
                                    contraseñas no coinciden</li>
                            </ul>
                        </div>

                    </div>

                    <div class="pt-10 align-bottom col-12 d-flex justify-content-center">
                        <button type="submit" id="submitButton" class="btn btn-outline-dark"
                            disabled>Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
