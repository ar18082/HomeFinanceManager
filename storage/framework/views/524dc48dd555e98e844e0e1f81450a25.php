<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Règles automatiques')); ?>

            </h2>
            <a href="<?php echo e(route('automatic-rules.create')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs  uppercase tracking-widest hover:bg-indigo-700">
                <?php echo e(__('Nouvelle règle')); ?>

            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Section d'explication -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('À propos des règles automatiques')); ?></h3>
                    <div class="prose max-w-none">
                        <p><?php echo e(__('Les règles automatiques vous permettent d\'automatiser la gestion de vos transactions en définissant des conditions et des actions à effectuer lorsque ces conditions sont remplies.')); ?></p>
                        
                        <h4 class="font-medium mt-4"><?php echo e(__('Comment ça marche ?')); ?></h4>
                        <ul class="list-disc pl-5 mt-2">
                            <li><?php echo e(__('Définissez des conditions basées sur la description, le montant, le type, la date, etc.')); ?></li>
                            <li><?php echo e(__('Choisissez les actions à effectuer : catégorisation, ajout/suppression de tags, modification de la description...')); ?></li>
                            <li><?php echo e(__('Les règles sont appliquées automatiquement à chaque nouvelle transaction ou modification.')); ?></li>
                            <li><?php echo e(__('Vous pouvez définir des priorités et choisir si une règle doit arrêter le traitement des suivantes.')); ?></li>
                        </ul>

                        <h4 class="font-medium mt-4"><?php echo e(__('Exemples d\'utilisation')); ?></h4>
                        <ul class="list-disc pl-5 mt-2">
                            <li><?php echo e(__('Catégoriser automatiquement les achats Amazon en "Shopping en ligne"')); ?></li>
                            <li><?php echo e(__('Ajouter le tag "Professionnel" à toutes les transactions contenant "SNCF"')); ?></li>
                            <li><?php echo e(__('Nettoyer automatiquement les descriptions des transactions bancaires')); ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Liste des règles -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <?php if($rules->isEmpty()): ?>
                        <div class="text-center py-8">
                            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                
                            </div>
                            <h3 class="text-lg font-medium text-gray-900"><?php echo e(__('Aucune règle automatique')); ?></h3>
                            <p class="mt-1 text-sm text-gray-500"><?php echo e(__('Commencez par créer une règle pour automatiser la gestion de vos transactions.')); ?></p>
                            <div class="mt-6">
                                <a href="<?php echo e(route('automatic-rules.create')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <?php echo e(__('Créer votre première règle')); ?>

                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Nom')); ?></th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Description')); ?></th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Priorité')); ?></th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Statut')); ?></th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Utilisations')); ?></th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Dernière utilisation')); ?></th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only"><?php echo e(__('Actions')); ?></span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="<?php echo e(route('automatic-rules.show', $rule)); ?>" class="hover:text-indigo-600">
                                                        <?php echo e($rule->name); ?>

                                                    </a>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500">
                                                    <?php echo e(Str::limit($rule->description, 50)); ?>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"><?php echo e($rule->priority); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($rule->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                                    <?php echo e($rule->active ? __('Active') : __('Inactive')); ?>

                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($rule->times_applied); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($rule->last_applied_at ? $rule->last_applied_at->diffForHumans() : __('Jamais')); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" 
                                                        class="text-indigo-600 hover:text-indigo-900 test-rule" 
                                                        data-rule-id="<?php echo e($rule->id); ?>"
                                                        data-rule-name="<?php echo e($rule->name); ?>">
                                                        <?php echo e(__('Tester')); ?>

                                                    </button>
                                                    <a href="<?php echo e(route('automatic-rules.edit', $rule)); ?>" class="text-indigo-600 hover:text-indigo-900"><?php echo e(__('Modifier')); ?></a>
                                                    <form action="<?php echo e(route('automatic-rules.destroy', $rule)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('Êtes-vous sûr de vouloir supprimer cette règle ?')); ?>')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="text-red-600 hover:text-red-900"><?php echo e(__('Supprimer')); ?></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de test -->
    <div id="testModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                <?php echo e(__('Tester la règle')); ?> : <span id="ruleName"></span>
                            </h3>
                            <div class="mt-4">
                                <label for="transaction" class="block text-sm font-medium text-gray-700"><?php echo e(__('Sélectionner une transaction')); ?></label>
                                <select id="transaction" name="transaction" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value=""><?php echo e(__('Choisir une transaction...')); ?></option>
                                </select>

                                <div id="testResults" class="mt-4 hidden">
                                    <h4 class="font-medium text-gray-900"><?php echo e(__('Résultats du test')); ?></h4>
                                    <div id="matchResult" class="mt-2 p-3 rounded-md"></div>
                                    <div id="changes" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="testButton" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        <?php echo e(__('Tester')); ?>

                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm close-modal">
                        <?php echo e(__('Fermer')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('testModal');
            const ruleNameSpan = document.getElementById('ruleName');
            const transactionSelect = document.getElementById('transaction');
            const testResults = document.getElementById('testResults');
            const matchResult = document.getElementById('matchResult');
            const changesDiv = document.getElementById('changes');
            let currentRuleId = null;

            // Charger les transactions lors de l'ouverture du modal
            async function loadTransactions() {
                try {
                    const response = await fetch('/api/transactions');
                    const transactions = await response.json();
                    
                    transactionSelect.innerHTML = '<option value=""><?php echo e(__("Choisir une transaction...")); ?></option>';
                    transactions.forEach(transaction => {
                        const option = document.createElement('option');
                        option.value = transaction.id;
                        option.textContent = `${transaction.date} - ${transaction.description} (${transaction.formatted_amount})`;
                        transactionSelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Erreur lors du chargement des transactions:', error);
                }
            }

            // Gestionnaire pour le bouton de test
            document.querySelectorAll('.test-rule').forEach(button => {
                button.addEventListener('click', () => {
                    currentRuleId = button.dataset.ruleId;
                    ruleNameSpan.textContent = button.dataset.ruleName;
                    modal.classList.remove('hidden');
                    loadTransactions();
                    testResults.classList.add('hidden');
                });
            });

            // Fermer le modal
            document.querySelectorAll('.close-modal').forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });

            // Tester la règle
            document.getElementById('testButton').addEventListener('click', async () => {
                const transactionId = transactionSelect.value;
                if (!transactionId) {
                    alert('<?php echo e(__("Veuillez sélectionner une transaction.")); ?>');
                    return;
                }

                try {
                    const response = await fetch(`/automatic-rules/${currentRuleId}/test`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ transaction_id: transactionId })
                    });

                    const result = await response.json();
                    
                    testResults.classList.remove('hidden');
                    
                    // Afficher si la règle correspond
                    matchResult.className = 'mt-2 p-3 rounded-md ' + (result.matches ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800');
                    matchResult.textContent = result.matches 
                        ? '<?php echo e(__("La règle correspond à cette transaction.")); ?>'
                        : '<?php echo e(__("La règle ne correspond pas à cette transaction.")); ?>';

                    // Afficher les changements potentiels
                    if (result.matches && result.changes.length > 0) {
                        changesDiv.innerHTML = `
                            <h5 class="font-medium text-gray-900 mt-4"><?php echo e(__("Changements qui seraient appliqués :")); ?></h5>
                            <ul class="mt-2 space-y-2">
                                ${result.changes.map(change => `
                                    <li class="text-sm">
                                        <span class="font-medium">${change.type} :</span>
                                        <span class="text-gray-500">${change.current}</span>
                                        <span class="text-gray-400 mx-2">→</span>
                                        <span class="text-gray-900">${change.new}</span>
                                    </li>
                                `).join('')}
                            </ul>
                        `;
                    } else {
                        changesDiv.innerHTML = '';
                    }
                } catch (error) {
                    console.error('Erreur lors du test de la règle:', error);
                    alert('<?php echo e(__("Une erreur est survenue lors du test de la règle.")); ?>');
                }
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/automatic-rules/index.blade.php ENDPATH**/ ?>