import { useForm } from "@inertiajs/inertia-react";
import { useState } from "react";
import { Button, Input, Label, Modal, Spinner, Textarea } from "./lib";

function EditProjectModal({ project }) {
    let [isVisible, setIsVisible] = useState(false);

    let {
        setData,
        patch,
        processing,
        errors: { title, description },
        reset,
        clearErrors,
    } = useForm({
        title: project.title,
        description: project.description,
    });

    function handleSubmit(e) {
        e.preventDefault();

        patch(`/projects/${project.id}`, {
            onSuccess: () => setIsVisible(false),
        });
    }

    function closeModal() {
        setIsVisible(false);
        reset();
        clearErrors();
    }

    return (
        <>
            <Button onClick={() => setIsVisible(true)} variant="dark">
                Edit
            </Button>
            <Modal isVisible={isVisible}>
                <div className="p-8">
                    <h2 className="mb-8 text-center text-2xl">
                        Edit the project
                    </h2>

                    <div>
                        <form className="space-y-4" onSubmit={handleSubmit}>
                            <div>
                                <Label htmlFor="title">Title</Label>
                                <Input
                                    type="text"
                                    id="title"
                                    onChange={(e) =>
                                        setData("title", e.target.value)
                                    }
                                    defaultValue={project.title}
                                />
                                {title && (
                                    <span className="text-sm font-semibold text-red-500">
                                        {title}
                                    </span>
                                )}
                            </div>

                            <div>
                                <Label htmlFor="description">Description</Label>
                                <Textarea
                                    type="text"
                                    id="description"
                                    rows="3"
                                    onChange={(e) =>
                                        setData("description", e.target.value)
                                    }
                                    defaultValue={project.description}
                                />
                                {description && (
                                    <span className="text-sm font-semibold text-red-500">
                                        {description}
                                    </span>
                                )}
                            </div>

                            <div className="flex items-center justify-between">
                                <span>{processing && <Spinner />}</span>
                                <div className="space-x-2">
                                    <Button
                                        variant="muted"
                                        type="button"
                                        onClick={closeModal}
                                    >
                                        Cancel
                                    </Button>
                                    <Button>Add Project</Button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </Modal>
        </>
    );
}

export default EditProjectModal;
