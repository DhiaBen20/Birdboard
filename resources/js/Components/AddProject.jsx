import { useForm } from "@inertiajs/inertia-react";
import { useState } from "react";
import { Button, Input, Label, Modal, Spinner, Textarea } from "./lib";

function AddProject() {
    let [isVisible, setIsVisible] = useState(false);

    let {
        setData,
        post,
        processing,
        errors: { title, description },
        reset,
        clearErrors,
    } = useForm();

    function handleSubmit(e) {
        e.preventDefault();

        post("/projects", {
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
            <Button onClick={() => setIsVisible((state) => !state)}>
                Add Project
            </Button>

            <Modal isVisible={isVisible} onClose={() => setIsVisible(false)}>
                <div className="p-8">
                    <h2 className="mb-8 text-center text-2xl">
                        Let's start something new
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

export default AddProject;
