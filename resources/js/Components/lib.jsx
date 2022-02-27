import { Link } from "@inertiajs/inertia-react";

function Spinner({ className }) {
    // return (
    //     <svg
    //         className={`initial:h-1 initial:w-1 animate-spin text-[#47d5fe] ${className}`}
    //         xmlns="http://www.w3.org/2000/svg"
    //         fill="none"
    //         viewBox="0 0 24 24"
    //     >
    //         <circle
    //             className="opacity-25"
    //             cx="12"
    //             cy="12"
    //             r="10"
    //             stroke="currentColor"
    //             strokeWidth="4"
    //         ></circle>
    //         <path
    //             className="opacity-75"
    //             fill="currentColor"
    //             d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
    //         ></path>
    //     </svg>
    // );

    return (
        <span
            className={`block animate-spin rounded-full border-[3px] border-[#3ec5fe] border-t-transparent ${
                className ?? "h-[20px] w-[20px]"
            }`}
        />
    );
}

function Button({ variant = "primary", size = "normal", ...props }) {
    let styles = {
        primary:
            "bg-[#3ec5fe] ring-[#3ec5fe]/40 hover:bg-[#00b3ff] text-white disabled:bg-[#5cc6f3]",
        muted: "bg-zinc-400/60 ring-zinc-400/25 hover:bg-zinc-400 text-white disabled:bg-zinc-400/20",
        dark: "text-white bg-gray-800/90 hover:bg-gray-800 ring-gray-400/80",
        normal: "px-4 py-2 text-sm uppercase",
        small: "px-4 py-2 text-xs uppercase",
    };

    return (
        <button
            className={`xtracking-widest rounded-md font-semibold transition duration-150 ease-in-out focus:outline-none focus:ring disabled:cursor-not-allowed ${styles[variant]} ${styles[size]}`}
            {...props}
        />
    );
}

function Label({ ...props }) {
    return (
        <label className="block text-sm font-medium text-gray-700" {...props} />
    );
}

function Input({ ...props }) {
    return (
        <input
            type="text"
            className="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#3ec5fe] focus:ring focus:ring-[#3ec5fe]/30"
            {...props}
        />
    );
}

function Textarea({ ...props }) {
    return (
        <textarea
            className="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-[#3ec5fe] focus:ring focus:ring-[#3ec5fe]/30"
            {...props}
        />
    );
}

function Modal({ isVisible, children, className }) {
    return (
        <>
            {isVisible && (
                <div className="absolute inset-0 z-20 flex items-center justify-center bg-gray-600/50">
                    <div
                        className={
                            className ??
                            "w-full max-w-xl rounded-xl bg-white shadow-xl"
                        }
                    >
                        {children}
                    </div>
                </div>
            )}
        </>
    );
}

function Card({ inline, ...props }) {
    return (
        <div
            className={`rounded-md bg-white p-4 shadow ${
                inline ? "flex items-center justify-between" : ""
            }`}
            {...props}
        />
    );
}

function CardHeader({ children, ...props }) {
    return (
        <div className="relative -ml-4 pl-4" {...props}>
            {children}
            <span className="absolute left-0 top-0 bottom-0 w-1 bg-[#3ec5fe]" />
        </div>
    );
}

function NavLink({ href, active, ...props }) {
    return (
        <Link
            href={href}
            className={`text-sm font-semibold ${
                active ? "text-black" : "text-gray-500"
            }`}
            {...props}
        />
    );
}

export {
    Spinner,
    Button,
    Input,
    Label,
    Textarea,
    Modal,
    Card,
    CardHeader,
    NavLink,
};
