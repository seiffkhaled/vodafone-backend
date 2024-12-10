<div>
    @foreach ($tasks as $task)
        <h1>{{ $task->title }}</h1>
        <h2>{{ $task->description }}</h2>
        <h3>{{ $task->start_date }}</h3>
    @endforeach
</div>
