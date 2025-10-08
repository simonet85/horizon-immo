

<?php $__env->startSection('title', 'Modifier demande #' . $application->id); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center space-x-4">
        <a href="<?php echo e(route('admin.applications.show', $application)); ?>" 
           class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Modifier demande #<?php echo e($application->id); ?></h1>
            <p class="text-gray-600 mt-1"><?php echo e($application->fullName); ?> - <?php echo e($application->created_at->format('d/m/Y H:i')); ?></p>
        </div>
    </div>

    <!-- Formulaire -->
    <form action="<?php echo e(route('admin.applications.update', $application)); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <!-- Statut -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Statut de la demande</h2>
            </div>
            <div class="px-6 py-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="status" 
                            id="status" 
                            class="mt-1 block w-full max-w-xs rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="pending" <?php echo e($application->status === 'pending' ? 'selected' : ''); ?>>En attente</option>
                        <option value="processing" <?php echo e($application->status === 'processing' ? 'selected' : ''); ?>>En cours</option>
                        <option value="completed" <?php echo e($application->status === 'completed' ? 'selected' : ''); ?>>Terminée</option>
                        <option value="rejected" <?php echo e($application->status === 'rejected' ? 'selected' : ''); ?>>Rejetée</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Informations personnelles -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Informations personnelles</h2>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom *</label>
                        <input type="text" 
                               name="first_name" 
                               id="first_name" 
                               value="<?php echo e(old('first_name', $application->first_name)); ?>"
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Nom *</label>
                        <input type="text" 
                               name="last_name" 
                               id="last_name" 
                               value="<?php echo e(old('last_name', $application->last_name)); ?>"
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="<?php echo e(old('email', $application->email)); ?>"
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="tel" 
                               name="phone" 
                               id="phone" 
                               value="<?php echo e(old('phone', $application->phone)); ?>"
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700">Âge</label>
                        <input type="number" 
                               name="age" 
                               id="age" 
                               min="18" 
                               max="120"
                               value="<?php echo e(old('age', $application->age)); ?>"
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="country_residence" class="block text-sm font-medium text-gray-700">Pays de résidence</label>
                        <select name="country_residence" 
                                id="country_residence" 
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['country_residence'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Sélectionner votre pays</option>
                            <option value="France" <?php echo e(old('country_residence', $application->country_residence) === 'France' ? 'selected' : ''); ?>>France</option>
                            <option value="Belgique" <?php echo e(old('country_residence', $application->country_residence) === 'Belgique' ? 'selected' : ''); ?>>Belgique</option>
                            <option value="Suisse" <?php echo e(old('country_residence', $application->country_residence) === 'Suisse' ? 'selected' : ''); ?>>Suisse</option>
                            <option value="Canada" <?php echo e(old('country_residence', $application->country_residence) === 'Canada' ? 'selected' : ''); ?>>Canada</option>
                            <option value="Autre" <?php echo e(old('country_residence', $application->country_residence) === 'Autre' ? 'selected' : ''); ?>>Autre</option>
                        </select>
                        <?php $__errorArgs = ['country_residence'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="profession" class="block text-sm font-medium text-gray-700">Profession</label>
                        <input type="text" 
                               name="profession" 
                               id="profession" 
                               value="<?php echo e(old('profession', $application->profession)); ?>"
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['profession'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['profession'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projet immobilier -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Projet immobilier</h2>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="property_type" class="block text-sm font-medium text-gray-700">Type de bien *</label>
                        <select name="property_type" 
                                id="property_type" 
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['property_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Sélectionner un type</option>
                            <option value="Appartement" <?php echo e(old('property_type', $application->property_type) === 'Appartement' ? 'selected' : ''); ?>>Appartement</option>
                            <option value="Maison" <?php echo e(old('property_type', $application->property_type) === 'Maison' ? 'selected' : ''); ?>>Maison</option>
                            <option value="Studio" <?php echo e(old('property_type', $application->property_type) === 'Studio' ? 'selected' : ''); ?>>Studio</option>
                            <option value="Local commercial" <?php echo e(old('property_type', $application->property_type) === 'Local commercial' ? 'selected' : ''); ?>>Local commercial</option>
                            <option value="Terrain" <?php echo e(old('property_type', $application->property_type) === 'Terrain' ? 'selected' : ''); ?>>Terrain</option>
                            <option value="Autre" <?php echo e(old('property_type', $application->property_type) === 'Autre' ? 'selected' : ''); ?>>Autre</option>
                        </select>
                        <?php $__errorArgs = ['property_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="desired_city" class="block text-sm font-medium text-gray-700">Ville souhaitée *</label>
                        <select name="desired_city" 
                                id="desired_city" 
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['desired_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Sélectionner une ville</option>
                            <option value="Cape Town" <?php echo e(old('desired_city', $application->desired_city) === 'Cape Town' ? 'selected' : ''); ?>>Le Cap</option>
                            <option value="Johannesburg" <?php echo e(old('desired_city', $application->desired_city) === 'Johannesburg' ? 'selected' : ''); ?>>Johannesburg</option>
                            <option value="Pretoria" <?php echo e(old('desired_city', $application->desired_city) === 'Pretoria' ? 'selected' : ''); ?>>Pretoria</option>
                            <option value="Durban" <?php echo e(old('desired_city', $application->desired_city) === 'Durban' ? 'selected' : ''); ?>>Durban</option>
                            <option value="Stellenbosch" <?php echo e(old('desired_city', $application->desired_city) === 'Stellenbosch' ? 'selected' : ''); ?>>Stellenbosch</option>
                            <option value="Hermanus" <?php echo e(old('desired_city', $application->desired_city) === 'Hermanus' ? 'selected' : ''); ?>>Hermanus</option>
                            <option value="Autre" <?php echo e(old('desired_city', $application->desired_city) === 'Autre' ? 'selected' : ''); ?>>Autre ville</option>
                        </select>
                        <?php $__errorArgs = ['desired_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="budget_range" class="block text-sm font-medium text-gray-700">Budget *</label>
                        <select name="budget_range" 
                                id="budget_range" 
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['budget_range'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Sélectionner un budget</option>
                            <option value="Moins de 100 000€" <?php echo e(old('budget_range', $application->budget_range) === 'Moins de 100 000€' ? 'selected' : ''); ?>>Moins de 100 000€</option>
                            <option value="100 000€ - 200 000€" <?php echo e(old('budget_range', $application->budget_range) === '100 000€ - 200 000€' ? 'selected' : ''); ?>>100 000€ - 200 000€</option>
                            <option value="200 000€ - 300 000€" <?php echo e(old('budget_range', $application->budget_range) === '200 000€ - 300 000€' ? 'selected' : ''); ?>>200 000€ - 300 000€</option>
                            <option value="300 000€ - 500 000€" <?php echo e(old('budget_range', $application->budget_range) === '300 000€ - 500 000€' ? 'selected' : ''); ?>>300 000€ - 500 000€</option>
                            <option value="500 000€ - 1 000 000€" <?php echo e(old('budget_range', $application->budget_range) === '500 000€ - 1 000 000€' ? 'selected' : ''); ?>>500 000€ - 1 000 000€</option>
                            <option value="Plus de 1 000 000€" <?php echo e(old('budget_range', $application->budget_range) === 'Plus de 1 000 000€' ? 'selected' : ''); ?>>Plus de 1 000 000€</option>
                        </select>
                        <?php $__errorArgs = ['budget_range'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="investment_type" class="block text-sm font-medium text-gray-700">Type d'investissement</label>
                        <select name="investment_type" 
                                id="investment_type" 
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['investment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Sélectionner un type</option>
                            <option value="Résidence principale" <?php echo e(old('investment_type', $application->investment_type) === 'Résidence principale' ? 'selected' : ''); ?>>Résidence principale</option>
                            <option value="Résidence secondaire" <?php echo e(old('investment_type', $application->investment_type) === 'Résidence secondaire' ? 'selected' : ''); ?>>Résidence secondaire</option>
                            <option value="Investissement locatif" <?php echo e(old('investment_type', $application->investment_type) === 'Investissement locatif' ? 'selected' : ''); ?>>Investissement locatif</option>
                            <option value="Autre" <?php echo e(old('investment_type', $application->investment_type) === 'Autre' ? 'selected' : ''); ?>>Autre</option>
                        </select>
                        <?php $__errorArgs = ['investment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="financial_situation" class="block text-sm font-medium text-gray-700">Situation financière</label>
                        <select name="financial_situation" 
                                id="financial_situation" 
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['financial_situation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Sélectionner une situation</option>
                            <option value="Financement personnel" <?php echo e(old('financial_situation', $application->financial_situation) === 'Financement personnel' ? 'selected' : ''); ?>>Financement personnel</option>
                            <option value="Crédit immobilier" <?php echo e(old('financial_situation', $application->financial_situation) === 'Crédit immobilier' ? 'selected' : ''); ?>>Crédit immobilier</option>
                            <option value="Mixte" <?php echo e(old('financial_situation', $application->financial_situation) === 'Mixte' ? 'selected' : ''); ?>>Mixte</option>
                            <option value="En cours d'étude" <?php echo e(old('financial_situation', $application->financial_situation) === 'En cours d\'étude' ? 'selected' : ''); ?>>En cours d'étude</option>
                        </select>
                        <?php $__errorArgs = ['financial_situation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="investment_goal" class="block text-sm font-medium text-gray-700">Objectif d'investissement</label>
                        <input type="text" 
                               name="investment_goal" 
                               id="investment_goal" 
                               value="<?php echo e(old('investment_goal', $application->investment_goal)); ?>"
                               placeholder="Ex: Rendement locatif, Plus-value, Défiscalisation..."
                               class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['investment_goal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['investment_goal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Message complémentaire</h2>
            </div>
            <div class="px-6 py-4">
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea name="message" 
                              id="message" 
                              rows="4" 
                              placeholder="Informations complémentaires, besoins spécifiques..."
                              class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('message', $application->message)); ?></textarea>
                    <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4">
            <a href="<?php echo e(route('admin.applications.show', $application)); ?>" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium">
                Annuler
            </a>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\admin\applications\edit.blade.php ENDPATH**/ ?>