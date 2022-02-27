import {Card, CardHeader} from "./lib";
import CompleteTask from "./CompleteTask";

function TaskCard({task}) {
    return (
        <Card inline>
            <CardHeader>{task.body}</CardHeader>

            <CompleteTask task={task} />
        </Card>
    );
}

export default TaskCard;
