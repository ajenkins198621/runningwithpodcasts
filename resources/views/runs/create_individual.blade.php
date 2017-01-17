<form method="post" action="/runs/create">
    <div class="form-group">
        <label for="distance">Distance</label>
        <input type="form-control" name="distance" id="distance" />
    </div>
    <div class="form-group">
        <label for="distance_units_id">Distance Units</label>
        <select name="distance_units_id" id="distance_units_id">
            @foreach($units as $unit)
                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="duration">Duration</label>
        <input type="form-control" name="duration" id="duration" />
    </div>
    <div class="form-group">
        <label for="location">Location</label>
        <input type="form-control" name="location" id="location" />
    </div>
    <div class="form-group">
        <label for="date">Date</label>
        <input type="form-control" name="date" id="date" />
    </div>

    <button class="btn btn-default" type="submit" name="submit" id="submit">Submit</button>
</form>