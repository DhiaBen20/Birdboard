import { Head, Link } from "@inertiajs/inertia-react";
import AddProject from "../../Components/AddProject";
import ProjectCard from "../../Components/ProjectCard";

function Index({ projects }) {
    return (
        <div className="pr-5">
            <Head title="Projects" />
            <div className="my-10 flex items-center justify-between">
                <Link href="/projects" className="text-gray-600">
                    My Projects
                </Link>

                <AddProject />
            </div>
            <div className="grid grid-cols-3 gap-6">
                {projects.map((project) => (
                    <ProjectCard key={project.id} project={project} />
                ))}
            </div>
        </div>
    );
}

export default Index;
