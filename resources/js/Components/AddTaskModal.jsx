import { useForm } from "@inertiajs/inertia-react";
import { useState } from "react";
import { Button, Input, Label, Modal, Spinner } from "./lib";

function AddTaskModal({ project }) {
    let [isVisible, setIsVisible] = useState(false);
    let {
        setData,
        post,
        processing,
        errors: { body },
        reset,
        clearErrors,
    } = useForm();

    function handleSubmit(e) {
        e.preventDefault();

        post(`/projects/${project.id}/tasks`, {
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
            <Button variant="dark" onClick={() => setIsVisible(true)}>
                Add Task
            </Button>
            <Modal isVisible={isVisible}>
                <div className="p-8">
                    <h2 className="mb-8 text-center text-2xl">Add new task</h2>

                    <div>
                        <form className="space-y-4" onSubmit={handleSubmit}>
                            <div>
                                <Label htmlFor="body">Task</Label>
                                <Input
                                    type="text"
                                    id="body"
                                    onChange={(e) =>
                                        setData("body", e.target.value)
                                    }
                                />
                                {body && (
                                    <span className="text-sm font-semibold text-red-500">
                                        {body}
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
                                        disabled={processing}
                                    >
                                        Cancel
                                    </Button>
                                    <Button disabled={processing}>
                                        Add Project
                                    </Button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </Modal>
        </>
    );
}

export default AddTaskModal;
