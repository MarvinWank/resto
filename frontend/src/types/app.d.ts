interface currentMessage {
    text: string,
    type: messageType,
}

export type messageType = "error" | "success"
