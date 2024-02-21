"use strict";
(self.webpackChunkranky_media_bundle = self.webpackChunkranky_media_bundle || []).push([[922], {
    7028: function (e, t, a) {
        a.r(t), a.d(t, {
            default: function () {
                return v
            }
        });
        var l = a(7294), i = a(4044), r = a(8062), n = a(2425);
        var m = e => {
            let {media: t} = e;
            return l.createElement("object", {
                type: t.file.mime,
                data: t.file.url
            }, l.createElement("img", {
                "aria-hidden": "true",
                src: (0, n.Z)("images/placeholder/application.jpg"),
                alt: t.description.alt,
                title: `${t.description.title} (${t.file.mime})`
            }))
        };
        var d = e => {
            let {media: t} = e;
            return l.createElement("object", {
                type: t.file.mime,
                data: t.file.url
            }, l.createElement("img", {
                "aria-hidden": "true",
                src: (0, n.Z)("images/placeholder/text.jpg"),
                alt: t.description.alt,
                title: `${t.description.title} (${t.file.mime})`
            }))
        };
        var o = e => {
            let {media: t} = e;
            return l.createElement("audio", {
                controls: !0,
                src: t.file.url,
                title: `${t.description.title} (${t.file.mime})`
            }, l.createElement("track", {kind: "captions"}), "Your browser does not support the ", l.createElement("code", null, "audio"), " element.")
        };
        var s = e => {
            let {media: t} = e;
            return l.createElement("video", {
                controls: !0,
                title: `${t.description.title} (${t.file.mime})`
            }, l.createElement("source", {
                src: t.file.url,
                type: t.file.mime
            }), l.createElement("track", {kind: "captions"}), "Sorry, your browser doesn't support embedded videos.")
        };
        var c = a(1202);
        const u = {
            application: m, audio: o, image: e => {
                let {media: t} = e;
                const a = (0, c.Z)();
                if (Object.keys(a.placeholderImageTypes).includes(t.file.mimeSubType)) return l.createElement("a", {
                    target: "_blank",
                    href: t.file.url,
                    "aria-label": `${t.description.title} (opens in a new window)`,
                    rel: "noreferrer"
                }, l.createElement("img", {
                    src: (0, n.Z)(a.placeholderImageTypes[t.file.mimeSubType]),
                    "data-mime-type": t.file.mimeType,
                    "data-mime-sub-type": t.file.mimeSubType,
                    alt: t.description.alt,
                    title: `${t.description.title} (${t.file.mime})`
                }));
                if (!a.supportedImageTypes.includes(t.file.mimeSubType)) return l.createElement("a", {
                    target: "_blank",
                    href: t.file.url,
                    "aria-label": `${t.description.title} (opens in a new window)`,
                    rel: "noreferrer"
                }, l.createElement("img", {
                    className: "ranky-img-placeholder ranky-img-placeholder--show",
                    src: (0, n.Z)("images/placeholder/image.jpg"),
                    "data-mime-type": t.file.mimeType,
                    "data-mime-sub-type": t.file.mimeSubType,
                    alt: t.description.alt,
                    title: `${t.description.title} (${t.file.mime})`
                }));
                let i = `${t.file.url} ${t.dimension.width}w,`;
                return t.thumbnails.forEach((e => {
                    i += ` ${e.url} ${e.dimension.width}w,`
                })), l.createElement("a", {
                    target: "_blank",
                    href: t.file.url,
                    "aria-label": `${t.description.title} (opens in a new window)`,
                    rel: "noreferrer"
                }, l.createElement("img", {
                    src: t.file.url,
                    "data-mime-type": t.file.mimeType,
                    "data-mime-sub-type": t.file.mimeSubType,
                    width: t.dimension.width ?? "auto",
                    height: t.dimension.height ?? "auto",
                    srcSet: t.dimension.width ? (r = i, m = ",", r.slice(-1) === m ? r.slice(0, -1) : r) : "",
                    alt: t.description.alt,
                    title: `${t.description.title}`
                }));
                var r, m
            }, "image_svg+xml": e => {
                let {media: t} = e;
                return l.createElement("a", {
                    target: "_blank",
                    href: t.file.url,
                    "aria-label": `${t.description.title} (opens in a new window)`,
                    rel: "noreferrer"
                }, l.createElement("img", {
                    className: "img-svg-preview",
                    src: t.file.url,
                    "data-mime-type": t.file.mimeType,
                    "data-mime-sub-type": t.file.mimeSubType,
                    alt: t.description.alt,
                    title: `${t.description.title}`
                }))
            }, video: s, text: d
        };
        var p = e => {
            let {media: t} = e;
            const a = `${t.file.mimeType}_${t.file.mimeSubType}`, i = t.file.mimeType,
                r = u[a] || u[i] || u.application;
            return l.createElement(r, {media: t})
        }, f = a(5633), E = a(4973), _ = a(6363), b = a(35), g = a(3665);
        var y = e => {
            var t;
            let {onDelete: a} = e;
            const n = (0, i.Z)(), [m, d] = (0, g.KO)(_.W5),
                o = (0, b.QQ)(), [s, c] = (0, l.useState)(!1), [u, y] = (0, l.useState)({
                    id: m.id,
                    name: m.file.basename,
                    alt: m.description.alt,
                    title: m.description.title,
                    cite: m.description.cite
                }), h = e => {
                    const t = e.target, a = {[t.name]: t.value};
                    y({...u, ...a})
                };
            return l.createElement("div", {className: "ranky-media-modal-file__dialog__content__show"}, l.createElement("div", {className: "ranky-media-modal-file__dialog__content__show__preview"}, l.createElement(p, {media: m}), l.createElement("button", {
                type: "button",
                className: "ranky-media-modal-file__btn-media-danger js-delete-media",
                "data-id": m.id,
                disabled: s,
                onClick: e => a(e, c)
            }, "🗑️ ", l.createElement(r.Z, {message: "delete"}))), l.createElement("div", {className: "ranky-media-modal-file__dialog__content__show__info"}, l.createElement("table", null, l.createElement("tbody", null, l.createElement("tr", null, l.createElement("th", {
                scope: "row",
                "aria-label": "form_name"
            }, l.createElement(r.Z, {message: "form_name"})), l.createElement("td", null, m.file.name)), l.createElement("tr", null, l.createElement("th", {scope: "row"}, "URL"), l.createElement("td", null, l.createElement("a", {
                target: "_blank",
                href: m.file.url,
                rel: "noreferrer"
            }, m.file.url))), l.createElement("tr", null, l.createElement("th", {
                scope: "row",
                "aria-label": "file_type"
            }, l.createElement(r.Z, {message: "file_type"})), l.createElement("td", null, m.file.mime)), null != m && null !== (t = m.dimension) && void 0 !== t && t.label ? l.createElement("tr", null, l.createElement("th", {
                scope: "row",
                "aria-label": "dimensions"
            }, l.createElement(r.Z, {message: "dimensions"})), l.createElement("td", null, m.dimension.label)) : null, l.createElement("tr", null, l.createElement("th", {
                scope: "row",
                "aria-label": "size"
            }, l.createElement(r.Z, {message: "size"})), l.createElement("td", null, m.file.humanSize)), l.createElement("tr", null, l.createElement("th", {
                scope: "row",
                "aria-label": "created_at"
            }, l.createElement(r.Z, {message: "created_at"})), l.createElement("td", null, m.createdAt, " ", l.createElement(r.Z, {message: "by"}), " ", m.createdBy)), l.createElement("tr", null, l.createElement("th", {
                scope: "row",
                "aria-label": "updated_at"
            }, l.createElement(r.Z, {message: "updated_at"})), l.createElement("td", null, m.updatedAt, " ", l.createElement(r.Z, {message: "by"}), " ", m.updatedBy)), l.createElement("tr", null, l.createElement("th", {scope: "row"}, l.createElement(r.Z, {message: "breakpoints"})), l.createElement("td", null, m.thumbnails.length > 0 ? l.createElement("ul", null, m.thumbnails.map((e => l.createElement("li", {key: e.name + e.breakpoint}, l.createElement("a", {
                target: "_blank",
                rel: "noopener noreferrer",
                href: e.url
            }, l.createElement("b", null, e.breakpoint, ":"), " ", e.dimension.label, " ", l.createElement("b", null, "size:"), " ", e.humanSize))))) : "-")))), l.createElement("form", {
                name: "media",
                id: "ranky-media-file__form",
                method: "POST",
                autoComplete: "off",
                encType: "multipart/form-data",
                onSubmit: async e => {
                    e.preventDefault(), c(!0);
                    const {id: t} = m, {data: a, error: l} = await f.Z.create(u).put(t);
                    return l ? (console.log(l), c(!1), (0, E.sD)(l)) : (d(a), y({
                        ...u,
                        name: a.file.basename,
                        alt: a.description.alt,
                        title: a.description.title
                    }), o.update(a), c(!1), (0, E.Cq)())
                }
            }, l.createElement("div", {className: "input-group"}, l.createElement("label", {htmlFor: "name"}, l.createElement(r.Z, {message: "form_name"})), l.createElement("input", {
                type: "text",
                name: "name",
                id: "ranky-media-file__form__name",
                value: u.name,
                onChange: h,
                required: !0,
                autoComplete: "off"
            }), l.createElement("span", {className: "input-group-text"}, ".", m.file.extension)), l.createElement("label", {htmlFor: "alt"}, l.createElement(r.Z, {message: "form_alt"})), l.createElement("input", {
                type: "text",
                name: "alt",
                id: "ranky-media-file__form__alt",
                value: u.alt,
                onChange: h,
                required: !0
            }), l.createElement("label", {htmlFor: "title"}, l.createElement(r.Z, {message: "form_title"})), l.createElement("input", {
                type: "text",
                name: "title",
                id: "ranky-media-file__form__title",
                value: u.title,
                onChange: h,
                required: !0
            }), l.createElement("label", {htmlFor: "cite"}, l.createElement(r.Z, {message: "form_cite"})), l.createElement("input", {
                type: "text",
                name: "cite",
                id: "ranky-media-file__form__cite",
                value: u.cite,
                onChange: h,
                required: !0
            }), l.createElement("input", {
                type: "hidden",
                name: "id",
                id: "ranky-media-file__form__id",
                defaultValue: u.id
            }), l.createElement("input", {type: "submit", disabled: s, value: n.trans("form_save")}))))
        }, h = a(8767);
        var v = e => {
            let {onClose: t} = e;
            const [a, i] = (0, g.KO)(_.W5), n = (0, h.useQueryClient)(), m = (0, b.QQ)();
            return l.createElement("div", {
                className: "wrapper-ranky-media-modal-file",
                key: `ranky-media-modal-file-${a.id}`
            }, l.createElement("div", {
                className: "ranky-media-modal-file ranky-media-modal-file--show",
                tabIndex: -1,
                "aria-labelledby": "ranky-media-modal-file",
                "aria-modal": "true",
                role: "dialog"
            }, l.createElement("div", {
                className: "ranky-media-modal-file__dialog",
                role: "document"
            }, l.createElement("div", {className: "ranky-media-modal-file__dialog__header ranky-media-modal-file__dialog--bg-primary-dark"}, l.createElement("h3", {className: "ranky-media-modal-file__dialog__header__title"}, l.createElement(r.Z, {
                message: "modal_title",
                data: {file_name: a.file.name, id: a.id}
            })), l.createElement("div", {className: "ranky-media-modal-file__dialog__header__options"}, l.createElement("ul", null, l.createElement("li", null, l.createElement("button", {
                onClick: function (e) {
                    let {currentTarget: t} = e;
                    const l = m.get(), r = m.findIndex(a.id), n = l.pages[r.page].result[r.index - 1],
                        d = l.pages.length, o = r.page > 0 && r.page < d;
                    if (n) return i(n), t.removeAttribute("disabled");
                    if (o) {
                        var s;
                        const e = l.pages[r.page - 1].result.length - 1,
                            a = (null === (s = l.pages[r.page - 1]) || void 0 === s ? void 0 : s.result[e]) || null;
                        if (a) return i(a), t.removeAttribute("disabled")
                    }
                    return t.setAttribute("disabled", "")
                },
                type: "button",
                className: "ranky-media-modal-file__btn-media-prev js-prev-modal",
                "aria-label": "Prev"
            }, l.createElement("span", {"aria-hidden": "true"}, "←"))), l.createElement("li", null, l.createElement("button", {
                onClick: function (e) {
                    var t;
                    let {currentTarget: l} = e;
                    const r = m.get(), n = m.findIndex(a.id), d = r.pages.length > n.page,
                        o = (null === (t = r.pages[n.page]) || void 0 === t ? void 0 : t.result[n.index + 1]) || null;
                    if (o) return i(o), l.removeAttribute("disabled");
                    if (d) {
                        var s;
                        const e = (null === (s = r.pages[n.page + 1]) || void 0 === s ? void 0 : s.result[0]) || null;
                        if (e) return i(e), l.removeAttribute("disabled")
                    }
                    return l.setAttribute("disabled", "")
                },
                type: "button",
                className: "ranky-media-modal-file__btn-media-next js-next-modal",
                "aria-label": "Next"
            }, l.createElement("span", {"aria-hidden": "true"}, "→"))), l.createElement("li", null, l.createElement("button", {
                onClick: t,
                type: "button",
                className: "ranky-media-modal-file__btn-media-close js-close-modal",
                "aria-label": "Close"
            }, l.createElement("span", {"aria-hidden": "true"}, "×")))))), l.createElement("div", {className: "ranky-media-modal-file__dialog__content"}, l.createElement(y, {
                onDelete: async (e, a) => {
                    e.preventDefault();
                    const l = e.currentTarget;
                    return (0, E.vl)((async () => {
                        const {id: e} = l.dataset;
                        a(!0);
                        const {data: i, error: r} = await f.Z.create().delete(e);
                        r ? await (0, E.sD)(r) : (await n.invalidateQueries("filters"), await n.invalidateQueries(["media", "list"]), await (0, E.Cq)(null == i ? void 0 : i.message), t()), a(!1)
                    }))
                }
            })))), l.createElement("div", {className: "ranky-media-modal-file-backdrop"}))
        }
    }
}]);