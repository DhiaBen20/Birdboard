import { useForm } from "@inertiajs/inertia-react";
import { useState } from "react";
import { Button, Input, Label, Modal, Spinner } from "./lib";

function InviteUserModal({ project }) {
    let [isVisible, setIsVisible] = useState(false);
    let {
        setData,
        errors: { email },
        processing,
        reset,
        clearErrors,
        post,
    } = useForm();

    function handleSubmit(e) {
        e.preventDefault();

        post(`/projects/${project.id}/invitations`, {
            onSuccess: () => setIsVisible(false),
        });
    }

    function handleClose() {
        setIsVisible(false);
        reset();
        clearErrors();
    }

    return (
        <>
            <Button onClick={() => setIsVisible(true)}>
                Invite to project
            </Button>
            <Modal isVisible={isVisible}>
                <div className="p-8 relative">
                    <h2 className="mb-8 text-center text-2xl">
                        Invite user to the project
                    </h2>

                    <form onSubmit={handleSubmit}>
                        <div>
                            <Label htmlFor="email">Email</Label>
                            <Input
                                type="email"
                                id="email"
                                onChange={(e) =>
                                    setData("email", e.target.value)
                                }
                            />
                            {email && (
                                <span className="text-sm font-semibold text-red-500">
                                    {email}
                                </span>
                            )}
                        </div>

                        <div className="mt-6 flex items-center justify-between">
                            <span>{processing && <Spinner />}</span>
                            <div className="space-x-2">
                                <Button
                                    variant="muted"
                                    onClick={handleClose}
                                    disabled={processing}
                                >
                                    Cancel
                                </Button>
                                <Button disabled={processing}>Invite</Button>
                            </div>
                        </div>
                    </form>
                </div>
            </Modal>
        </>
    );
}

export default InviteUserModal;
