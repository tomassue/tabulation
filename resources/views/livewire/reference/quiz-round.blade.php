    
    <section class="section round">
        <div class="row">
            <div class="col-lg-12">
                <section class="section oratorical">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-10 mx-auto">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Add Round</h5>
                                        <div class="toolbar mb-3 d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary" wire:click="addRound">
                                                Add
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <!-- Table with hoverable rows -->
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($rounds as $item)
                                                        <tr>
                                                            <th scope="row">
                                                                {{$loop->iteration}}
                                                            </th>
                                                            <th scope="row">
                                                                {{$item->round}}
                                                            </th>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary" wire:click="editRound({{$item->id}})">
                                                                    Edit
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- End Table with hoverable rows -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    <!-- Modal -->
<div class="modal fade" id="roundModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="saveRound">
                <div class="modal-body">
                     @include('layouts.message')
                    <div class="mb-3">
                        <label for="roundName" class="form-label">Round's Name</label>
                        <input type="text" class="form-control" wire:model="round" id="roundName" placeholder="Enter round's name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
    
@script
<script>
    
    window.addEventListener('openModal', event => {
        var myModal = new bootstrap.Modal(document.getElementById('roundModal'));
        myModal.show();
    });
     window.addEventListener('hideModal', event => {
        var myModal = new bootstrap.Modal(document.getElementById('roundModal'));
        myModal.show();
    });
</script>
@endscript