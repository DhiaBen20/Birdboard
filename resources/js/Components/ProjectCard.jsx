import { Link } from "@inertiajs/inertia-react";
import {Card, CardHeader} from "./lib";

function ProjectCard({ project }) {
    return (
        <Card>
            <CardHeader>
                <h2 className="py-2 xfont-bold text-xl">
                    <Link href={`/projects/${project.id}`}>{project.title}</Link>
                </h2>
            </CardHeader>
            <p className="mt-6 text-gray-600 leading-relaxed tracking-wide">
                {project.description}
            </p>
        </Card>
    );
}

export default ProjectCard;
