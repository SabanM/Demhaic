<x-app-layout>
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.Identifiers', [], session()->get('applocale')) }}                       
        </h2>
    @endsection

    @section('maincontent')
    <!-- Create New Identifier Button -->
    <div class="max-w-12xl mx-auto sm:px-8 mt-2 lg:px-10">
        <div class="container">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="col-md-8">
                        <p class="c-grey h4">{{ __('messages.Identifiers', [], session()->get('applocale')) }}</p>
                    </div>
                    <div class="col-md-4 d-flex justify-content-end align-items-start">
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fa fa-plus"></i> {{ __('messages.Add new', [], session()->get('applocale')) }} +
                        </button>
                    </div>
                </div>

                <!-- identifiers Table -->
                <div class="row container mt-2">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('messages.Name', [], session()->get('applocale')) }}</th>
                                <th>{{ __('messages.Description', [], session()->get('applocale')) }}</th>
                           
                                <th>{{ __('messages.Actions', [], session()->get('applocale')) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($identifiers as $identifier)

                      
                            <tr>
                                <td>{{ $identifier->name }}</td>
                                <td>{{ $identifier->description }}</td>
                         
                                <td class="text-end align-middle">
                                    <div class="d-flex justify-content-end gap-2 flex-nowrap">
                                        <!-- Edit Button -->
                                       <button
                                            type="button"
                                            class="btn btn-sm btn-warning d-inline-flex align-items-center"
                                            data-identifier='@json($identifier)'
                                            onclick="openEditModal(this)">
                                            <i class="fa fa-edit me-1 mr-2"></i>
                                            {{ __('messages.Edit', [], session()->get('applocale')) }}
                                        </button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('identifiers.destroy', $identifier->id) }}" method="POST" id="deleteForm-{{ $identifier->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center"
                                                onclick="confirmDelete({{ $identifier->id }})">
                                                <i class="fa fa-trash me-1 mr-2"></i>
                                                {{ __('messages.Delete', [], session()->get('applocale')) }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editIdentifierForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">{{ __('messages.Edit Identifier', [], session()->get('applocale')) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label">{{ __('messages.Name', [], session()->get('applocale')) }}</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">{{ __('messages.Description', [], session()->get('applocale')) }}</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3" required></textarea>
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.Close', [], session()->get('applocale')) }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('messages.Save', [], session()->get('applocale')) }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('identifiers.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">{{ __('messages.Create new identifier', [], session()->get('applocale')) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="createName" class="form-label">{{ __('messages.Name', [], session()->get('applocale')) }}</label>
                            <input type="text" class="form-control" id="createName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="createDescription" class="form-label">{{ __('messages.Description', [], session()->get('applocale')) }}</label>
                            <textarea class="form-control" id="createDescription" name="description" rows="3" required></textarea>
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.Close', [], session()->get('applocale')) }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('messages.Save', [], session()->get('applocale')) }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection

    @section('scripts')
    <!-- Include Bootstrap JS if not already included in layout -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this identifier?")) {
                document.getElementById('deleteForm-' + id).submit();
            }
        }

        function openEditModal(button) {
            const identifier = JSON.parse(button.getAttribute('data-identifier'));
            const url = '/identifiers/'+identifier.id+'/edit';
            document.getElementById('editIdentifierForm').action = url;
            document.getElementById('editName').value = identifier.name;
            document.getElementById('editDescription').value = identifier.description;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        // Optional: Reset Create Modal Fields
        document.getElementById('createModal')?.addEventListener('hidden.bs.modal', () => {
            document.getElementById('createName').value = '';
            document.getElementById('createDescription').value = '';
        });
    </script>
    @endsection
</x-app-layout>
