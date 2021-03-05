const { __ } = wp.i18n;

export default function getPenHTML(attributes) {
  const {
    penID,
    penTheme,
    penHeight,
    penURL,
    penType,
    clickToLoad
  } = attributes;

  if (penID === null && penURL === "") {
    return null;
  }

  if (null === penID) {
    return (
      <p className="codepen error" style={{ textAlign: "center" }}>
        {__("The pen URL is invalid.")}
      </p>
    );
  }

  let embedUrlPrefix = "//codepen.io/anon/embed";
  if (clickToLoad) {
    embedUrlPrefix += "/preview";
  }

  return (
    <div className="cp_embed_wrapper">
      <iframe
        id={`cp_embed_${penID}`}
        src={`${embedUrlPrefix}/${penID}?height=${penHeight}&theme-id=${penTheme}&slug-hash=${penID}&default-tab=${penType}`}
        height={penHeight}
        scrolling="no"
        frameborder="0"
        allowTransparency={true}
        allowFullScreen={true}
        allowpaymentrequest="true"
        name={`CodePen Embed ${penID}`}
        title={`CodePen Embed ${penID}`}
        className={"cp_embed_iframe"}
        style={{ width: "100%", overflow: "hidden" }}
      >
        CodePen Embed Fallback
      </iframe>
    </div>
  );
}
