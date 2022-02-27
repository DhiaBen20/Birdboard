import { Head, Link } from "@inertiajs/inertia-react";
import AddTaskModal from "../../Components/AddTaskModal";
import EditProjectModal from "../../Components/EditProjectModal";
import GeneralNotes from "../../Components/GeneralNotes";
import InviteUserModal from "../../Components/InviteUserModal";
import ProjectCard from "../../Components/ProjectCard";
import TaskCard from "../../Components/TaskCard";

function Show({ project }) {
    return (
        <div className="w-full pr-5">
            <Head title={project.title} />
            <div className="my-10 flex items-center justify-between">
                <div>
                    <Link href="/projects" className="mr-8 text-gray-600">
                        My Projects
                    </Link>

                    <EditProjectModal project={project} />
                </div>

                <InviteUserModal project={project} />
            </div>

            <div className="grid grid-cols-3 gap-x-5">
                <div className="col-span-2 mb-4 flex items-end justify-between">
                    <h3 className="text-lg text-gray-600">Tasks</h3>

                    <AddTaskModal project={project} />
                </div>

                <div className="col-span-2">
                    <div className="space-y-4">
                        {project.tasks.map((task) => (
                            <TaskCard key={task.id} task={task} />
                        ))}
                    </div>

                    <GeneralNotes project={project} />
                </div>
                <div>
                    <ProjectCard project={project} />
                </div>
            </div>
        </div>
    );
}

export default Show;
