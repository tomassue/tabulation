<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover table-bordered align-middle">
                <thead>
                    <th>CATEGORY</th>
                    <th>ALL</th>
                    <th>FIRST</th>
                    <th>SECOND</th>
                    <th>THIRD</th>
                </thead>
                <tbody>
                    @foreach ($leds as $item)
                        <tr>
                            <td>{{$item->category}} 
                                <select name="category" wire:model="category" id="category" wire:change="changeCategory">
                                    <option value="quiz">Quiz</option>
                                    <option value="oral">Oral</option>
                                    <option value="poster">Poster</option>
                                </select>
                            </td>
                            <td>{{$item->show_all}} <button wire:click="changeAll">Update</button></td>
                            <td>{{$item->show_first}} <button wire:click="changeFirst">Update</button></td>
                            <td>{{$item->show_second}} <button wire:click="changeSecond">Update</button></td>
                            <td>{{$item->show_third}} <button wire:click="changeThird">Update</button></td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
        </div>
    </div>
</section>
