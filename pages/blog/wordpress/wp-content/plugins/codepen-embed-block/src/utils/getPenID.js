export default function getPenID(penURL) {
  let matches_array = penURL.match(
    /http[s]?:\/\/codepen\.io\/(?:team\/)?[\w-]+\/(?:pen|details|full|pres|debug|live|embed)\/([A-Za-z]{5,8}|[A-Z-a-z0-9]{32,})\/?/
  );
  return Array.isArray(matches_array) ? matches_array[1] : null;
}
